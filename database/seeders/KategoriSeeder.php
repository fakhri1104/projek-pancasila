<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Matiin sementara foreign key check
        Schema::disableForeignKeyConstraints();

        // Kosongin tabel (opsional, biar ga duplikat)
        DB::table('kategori')->truncate();

        // Data kategori FIXED dari sistem
        $kategori = [
            [
                'nama' => 'Fasilitas Sekolah',
                'deskripsi' => 'Aspirasi terkait kerusakan atau perbaikan fasilitas sekolah seperti kelas, toilet, laboratorium, lapangan, dll',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kebersihan',
                'deskripsi' => 'Aspirasi tentang kebersihan lingkungan sekolah, pengelolaan sampah, dan sanitasi',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Keamanan',
                'deskripsi' => 'Aspirasi terkait keamanan lingkungan sekolah, baik untuk siswa, guru, maupun aset sekolah',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Pembelajaran',
                'deskripsi' => 'Aspirasi tentang proses belajar mengajar, kurikulum, metode pengajaran, dan tugas',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kantin',
                'deskripsi' => 'Aspirasi tentang kantin sekolah, kebersihan makanan, harga, dan pelayanan',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Olahraga',
                'deskripsi' => 'Aspirasi tentang fasilitas olahraga, kegiatan olahraga, dan ekstrakurikuler olahraga',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ekstrakurikuler',
                'deskripsi' => 'Aspirasi tentang kegiatan ekstrakurikuler non-olahraga seperti pramuka, PMR, seni, dll',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Lainnya',
                'deskripsi' => 'Aspirasi yang tidak termasuk dalam kategori di atas',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insert batch
        DB::table('kategori')->insert($kategori);

        // Hidupin lagi foreign key check
        Schema::enableForeignKeyConstraints();

        $this->command->info('✅ ' . count($kategori) . ' kategori berhasil ditambahkan!');
    }
}
