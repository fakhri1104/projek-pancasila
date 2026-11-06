<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminKategoriController extends Controller
{
    /**
     * Tampilkan daftar kategori
     */
    public function index()
    {
        $kategoris = Kategori::withCount('aspirasis')->orderBy('created_at', 'desc')->get();
        return view('admin.data_kategori', compact('kategoris'));
    }

    /**
     * Tampilkan halaman form tambah kategori
     */
    public function create()
    {
        return view('admin.tambah_kategori');
    }

    /**
     * Simpan data kategori baru
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama',
            'deskripsi' => 'required|string|max:500',
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        try {
            // Buat kategori baru
            $kategori = Kategori::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan!',
                'data' => [
                    'id' => $kategori->id,
                    'nama' => $kategori->nama,
                    'deskripsi' => $kategori->deskripsi,
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
     * Tampilkan form edit kategori
     */
    public function edit($id)
    {
        $kategori = Kategori::withCount('aspirasis')->findOrFail($id);
        return view('admin.edit_kategori', compact('kategori'));
    }

    /**
     * Update data kategori
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        // Validasi
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori,nama,' . $id,
            'deskripsi' => 'required|string|max:500',
        ], [
            'nama.required' => 'Nama kategori harus diisi',
            'nama.unique' => 'Nama kategori sudah ada',
            'deskripsi.required' => 'Deskripsi harus diisi',
            'deskripsi.max' => 'Deskripsi maksimal 500 karakter',
        ]);

        try {
            $kategori->update([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diupdate!',
                'data' => [
                    'id' => $kategori->id,
                    'nama' => $kategori->nama,
                    'deskripsi' => $kategori->deskripsi,
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        try {
            $kategori = Kategori::findOrFail($id);

            // Cek apakah kategori sedang digunakan
            $jumlahAspirasi = $kategori->aspirasis()->count();

            if ($jumlahAspirasi > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $jumlahAspirasi . ' aspirasi'
                ], 400);
            }

            $kategori->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori: ' . $e->getMessage()
            ], 500);
        }
    }
}
