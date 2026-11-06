<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\RiwayatStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminAspirasiController extends Controller
{
    /**
     * Tampilkan halaman data aspirasi dengan semua data
     */
    public function index()
    {
        // Get all aspirasi with relationships
        $aspirasi = Aspirasi::with(['siswa', 'kategori'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Statistics
        $totalAspirasi = Aspirasi::count();
        $menunggu = Aspirasi::where('status', 'menunggu')->count();
        $diproses = Aspirasi::where('status', 'diproses')->count();
        $selesai = Aspirasi::where('status', 'selesai')->count();

        return view('admin.data_aspirasi', compact(
            'aspirasi',
            'totalAspirasi',
            'menunggu',
            'diproses',
            'selesai'
        ));
    }

    public function dashboard()
    {
        // Get all aspirasi statistics
        $totalAspirasi = Aspirasi::count();
        $menunggu = Aspirasi::where('status', 'menunggu')->count();
        $diproses = Aspirasi::where('status', 'diproses')->count();
        $selesai = Aspirasi::where('status', 'selesai')->count();

        // Get recent aspirasi (5 terbaru)
        $recentAspirasi = Aspirasi::with(['siswa', 'kategori', 'fotoPengaduan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get kategori terpopuler
        $kategoriTerpopuler = Aspirasi::select('kategori_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_id')
            ->orderBy('total', 'desc')
            ->with('kategori')
            ->first();

        // Calculate average response time (in days)
        $rataRataRespon = Aspirasi::whereNotNull('tanggal_selesai')
            ->get()
            ->avg(function($aspirasi) {
                if ($aspirasi->tanggal_selesai && $aspirasi->tanggal_kirim) {
                    return $aspirasi->tanggal_kirim->diffInDays($aspirasi->tanggal_selesai);
                }
                return 0;
            });

        // Monthly statistics for chart
        $monthlyStats = [];
        for ($i = 0; $i < 6; $i++) {
            $month = now()->subMonths($i);
            $monthlyStats[5 - $i] = Aspirasi::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'totalAspirasi',
            'menunggu',
            'diproses',
            'selesai',
            'recentAspirasi',
            'kategoriTerpopuler',
            'rataRataRespon',
            'monthlyStats'
        ));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'umpan_balik' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $statusSekarang = $aspirasi->status;
        $statusBaru = $request->status;

        // Validasi: Status selesai dan ditolak tidak bisa diubah (final state)
        if (in_array($statusSekarang, ['selesai', 'ditolak'])) {
            return response()->json([
                'success' => false,
                'message' => "Status '{$statusSekarang}' sudah final dan tidak bisa diubah lagi."
            ], 422);
        }

        // Validasi transisi status berdasarkan aturan bisnis
        $allowedTransitions = [
            'menunggu' => ['diproses', 'ditolak'],
            'diproses' => ['selesai', 'ditolak']
        ];

        if (!in_array($statusBaru, $allowedTransitions[$statusSekarang])) {
            $allowed = implode(' atau ', $allowedTransitions[$statusSekarang]);
            return response()->json([
                'success' => false,
                'message' => "Status dari '{$statusSekarang}' hanya bisa diubah ke {$allowed}."
            ], 422);
        }

        // Update status aspirasi
        $aspirasi->status = $statusBaru;

        // Set tanggal_selesai if status is selesai or ditolak
        if (in_array($statusBaru, ['selesai', 'ditolak']) && !$aspirasi->tanggal_selesai) {
            $aspirasi->tanggal_selesai = now()->toDateString();
        }

        $aspirasi->save();

        // Buat riwayat status baru
        $riwayat = RiwayatStatus::create([
            'laporan_id' => $aspirasi->id,
            'laporan_type' => Aspirasi::class,
            'admin_id' => Auth::guard('admin')->id(),
            'status' => $statusBaru,
            'umpan_balik' => $request->umpan_balik,
            'keterangan' => $request->keterangan
        ]);

        // Load admin relationship for response
        $riwayat->load('admin');

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui dan umpan balik ditambahkan',
            'aspirasi' => $aspirasi,
            'riwayat' => $riwayat
        ]);
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with(['siswa', 'kategori', 'fotoPengaduan', 'riwayatStatus.admin'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'aspirasi' => $aspirasi
        ]);
    }

    public function addFeedback(Request $request, $id)
    {
        $request->validate([
            'umpan_balik' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);

        // Buat riwayat status baru dengan status yang sama (hanya umpan balik)
        $riwayat = RiwayatStatus::create([
            'laporan_id' => $aspirasi->id,
            'laporan_type' => Aspirasi::class,
            'admin_id' => Auth::guard('admin')->id(),
            'status' => $aspirasi->status, // Status tetap sama
            'umpan_balik' => $request->umpan_balik,
            'keterangan' => $request->keterangan
        ]);

        // Load admin relationship for response
        $riwayat->load('admin');

        return response()->json([
            'success' => true,
            'message' => 'Umpan balik berhasil ditambahkan',
            'riwayat' => $riwayat
        ]);
    }

    /**
     * Get all riwayat status for a specific aspirasi
     */
    public function getRiwayatStatus($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);

        $riwayat = $aspirasi->riwayatStatus()
            ->with('admin')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'riwayat' => $riwayat
        ]);
    }
}
