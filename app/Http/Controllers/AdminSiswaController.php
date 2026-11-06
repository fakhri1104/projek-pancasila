<?php

namespace App\Http\Controllers;

use App\Models\Siswas\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminSiswaController extends Controller
{
    /**
     * Tampilkan daftar siswa
     */
    public function index()
    {
        $siswas = Siswa::withCount('aspirasis')->orderBy('created_at', 'desc')->paginate(35);

        // Ambil kelas unik untuk filter dropdown
        $kelasList = Siswa::select('kelas')
            ->distinct()
            ->orderBy('kelas', 'asc')
            ->pluck('kelas');

        return view('admin.data_siswa', compact('siswas', 'kelasList'));
    }

    /**
     * Tampilkan halaman form tambah siswa
     */
    public function create()
    {
        return view('admin.tambah_siswa');
    }

    /**
     * Simpan data siswa baru
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:10|unique:siswas,nisn',
            'kelas' => 'required|string|max:50',
            'email' => 'required|email|max:255|unique:siswas,email',
            'kata_sandi' => 'required|string|min:6',
        ], [
            'nama.required' => 'Nama harus diisi',
            'nisn.required' => 'NISN harus diisi',
            'nisn.unique' => 'NISN sudah terdaftar',
            'kelas.required' => 'Kelas harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'kata_sandi.required' => 'Password harus diisi',
            'kata_sandi.min' => 'Password minimal 6 karakter',
        ]);

        try {
            // Buat siswa baru dengan password yang di-hash
            $siswa = Siswa::create([
                'nama' => $request->nama,
                'nisn' => $request->nisn,
                'kelas' => $request->kelas,
                'email' => $request->email,
                'kata_sandi' => Hash::make($request->kata_sandi), // Hash password
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data siswa berhasil disimpan! Siswa dapat login menggunakan NISN dan password yang telah dibuat.',
                'data' => [
                    'id' => $siswa->id,
                    'nama' => $siswa->nama,
                    'nisn' => $siswa->nisn,
                    'kelas' => $siswa->kelas,
                    'email' => $siswa->email,
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus data siswa
     */
    public function destroy($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            $nama = $siswa->nama;

            $siswa->delete();

            return response()->json([
                'success' => true,
                'message' => "Data siswa {$nama} berhasil dihapus"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Tampilkan halaman edit siswa (untuk admin)
     */
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);

        return view('admin.edit_siswa', compact('siswa'));
    }

    /**
     * Update data siswa (untuk admin)
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Validate basic fields
        $request->validate([
            'nama' => 'required|string|max:255',
            'nisn' => 'required|string|max:10|unique:siswas,nisn,' . $siswa->id,
            'email' => 'required|email|unique:siswas,email,' . $siswa->id,
            'kelas' => 'required|string|max:20',
        ]);

        // Update basic fields
        $siswa->nama = $request->nama;
        $siswa->nisn = $request->nisn;
        $siswa->email = $request->email;
        $siswa->kelas = $request->kelas;

        // Handle password update if provided (admin doesn't need current password)
        if ($request->filled('new_password')) {
            // Validate password fields
            $request->validate([
                'new_password' => 'required|min:6|confirmed',
            ]);

            // Update password directly (admin privilege)
            $siswa->kata_sandi = Hash::make($request->new_password);
        }

        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa berhasil diperbarui!'
        ]);
    }
}
