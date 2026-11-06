<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Siswas\Siswa;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        Siswa::create([
            'nama' => 'Ahmad Fauzi',
            'email' => 'ahmadfauzi@example.com',
            'kata_sandi' => Hash::make('password123'),
            'nisn' => '1234567890',
            'kelas' => 'XII RPL 1',
        ]);

        Siswa::create([
            'nama' => 'Rina Putri',
            'email' => 'rinaputri@example.com',
            'kata_sandi' => Hash::make('password123'),
            'nisn' => '1234567891',
            'kelas' => 'XI RPL 2',
        ]);

        Siswa::create([
            'nama' => 'Dimas Pratama',
            'email' => 'dimas@example.com',
            'kata_sandi' => Hash::make('password123'),
            'nisn' => '1234567892',
            'kelas' => 'X RPL 3',
        ]);
    }
}
