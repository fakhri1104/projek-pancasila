<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admins\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat admin pertama (super admin)
        Admin::create([
            'nama' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'kata_sandi' => Hash::make('admin123'),
        ]);

        // Buat admin kedua
        Admin::create([
            'nama' => 'Admin Utama',
            'email' => 'admin@example.com',
            'kata_sandi' => Hash::make('admin123'),
        ]);

        // Buat admin ketiga (opsional)
        Admin::create([
            'nama' => 'Admin Sekolah',
            'email' => 'adminsekolah@example.com',
            'kata_sandi' => Hash::make('admin123'),
        ]);
    }
}
