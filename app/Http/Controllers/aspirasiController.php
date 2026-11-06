<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Aspirasi;
use App\Models\FotoPengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class AspirasiController extends Controller
{
    public function dashboard()
    {
        $siswaId = Auth::guard('siswa')->id();

        // Get all aspirasi for stats
        $totalAspirasi = Aspirasi::where('siswa_id', $siswaId)->count();
        $menunggu = Aspirasi::where('siswa_id', $siswaId)->where('status', 'menunggu')->count();
        $diproses = Aspirasi::where('siswa_id', $siswaId)->where('status', 'diproses')->count();
        $selesai = Aspirasi::where('siswa_id', $siswaId)->where('status', 'selesai')->count();

        // Get recent aspirasi (5 terbaru)
        $recentAspirasi = Aspirasi::where('siswa_id', $siswaId)
            ->with(['kategori', 'fotoPengaduan'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('siswa.dashboard_siswa', compact(
            'totalAspirasi',
            'menunggu',
            'diproses',
            'selesai',
            'recentAspirasi'
        ));
    }

    public function create()
    {
        // Sort kategori: "Lainnya" di paling bawah, sisanya alphabet
        $kategori = Kategori::orderByRaw("CASE WHEN LOWER(nama) = 'lainnya' THEN 1 ELSE 0 END, nama ASC")->get();
        return view('siswa.tambah_aspirasi', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:150',
            'kategori_id' => 'required|exists:kategori,id',
            'lokasi' => 'required|max:100',
            'deskripsi' => 'required|min:20',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=1280,max_height=1280' // 2MB, max 1280x1280
        ]);

        $aspirasi = Aspirasi::create([
            'siswa_id' => Auth::guard('siswa')->id(),
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'status' => 'menunggu',
            'tanggal_kirim' => now()->toDateString(),
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('aspirasi/' . $aspirasi->id, 'public');

                FotoPengaduan::create([
                    'aspirasi_id' => $aspirasi->id,
                    'url_foto' => Storage::url($path),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Aspirasi berhasil dikirim',
            'aspirasi_id' => $aspirasi->id
        ], 201);
    }

    public function history(Request $request)
    {
        $query = Aspirasi::where('siswa_id', Auth::guard('siswa')->id())
            ->with(['kategori', 'fotoPengaduan']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search by judul or deskripsi
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('deskripsi', 'like', '%' . $searchTerm . '%')
                  ->orWhere('lokasi', 'like', '%' . $searchTerm . '%');
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        if ($sortBy == 'terlama') {
            $query->orderBy('created_at', 'asc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $aspirasis = $query->get();

        return view('siswa.histori_aspirasi', compact('aspirasis'));
    }

    public function show($id)
    {
        $aspirasi = Aspirasi::with(['kategori', 'fotoPengaduan'])
            ->where('siswa_id', Auth::guard('siswa')->id())
            ->findOrFail($id);

        return view('siswa.detail_aspirasi', compact('aspirasi'));
    }

    public function profile()
    {
        $siswa = Auth::guard('siswa')->user();
        return view('siswa.detail_profile', compact('siswa'));
    }

    public function updateProfile(Request $request)
    {
        $siswa = Auth::guard('siswa')->user();

        // Validate basic fields
        $request->validate([
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
            'kelas' => 'required|string|max:20',
        ]);

        // Update email and kelas
        $siswa->email = $request->email;
        $siswa->kelas = $request->kelas;

        // Handle password update if provided
        if ($request->filled('current_password')) {
            // Validate password fields
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ]);

            // Check if current password is correct
            if (!Hash::check($request->current_password, $siswa->kata_sandi)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password saat ini tidak sesuai'
                ], 422);
            }

            // Update password
            $siswa->kata_sandi = Hash::make($request->new_password);
        }

        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui!'
        ]);
    }
}
