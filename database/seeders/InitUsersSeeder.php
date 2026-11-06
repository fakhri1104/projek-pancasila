<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admins\Admin;
use App\Models\Siswas\Siswa;
use Illuminate\Support\Facades\Hash;

class InitUsersSeeder extends Seeder
{
    public function run(): void
    {
        echo "Menghapus data lama...\n";

        // Hapus data lama
        Admin::truncate();
        Siswa::truncate();

        echo "Membuat data admin...\n";

        // Buat admin
        Admin::create([
            'nama' => 'Admin Sekolah',
            'email' => 'admin@sekolah.id',
            'kata_sandi' => Hash::make('password123'), // PAKAI Hash::make()
        ]);

        echo "Membuat data siswa...\n";

        // Buat siswa
        Siswa::create([
            'nama' => 'Andi Wijaya',
            'email' => 'andi@siswa.id',
            'kata_sandi' => Hash::make('password123'),
            'nisn' => '0012345678',
            'kelas' => 'XII IPA 1',
        ]);

        Siswa::create([
            'nama' => 'Siti Rahma',
            'email' => 'siti@siswa.id',
            'kata_sandi' => Hash::make('password123'),
            'nisn' => '0023456789',
            'kelas' => 'XII IPS 2',
        ]);

        echo "========================================\n";
        echo "DATA BERHASIL DIBUAT!\n";
        echo "========================================\n";
        echo "Admin Login:\n";
        echo "Email: admin@sekolah.id\n";
        echo "Password: password123\n";
        echo "----------------------------------------\n";
        echo "Siswa 1 Login:\n";
        echo "NISN: 0012345678\n";
        echo "Password: password123\n";
        echo "----------------------------------------\n";
        echo "Siswa 2 Login:\n";
        echo "NISN: 0023456789\n";
        echo "Password: password123\n";
        echo "========================================\n";
    }
}
