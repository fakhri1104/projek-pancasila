<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riwayat_status', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation - bisa untuk aspirasi atau pengaduan
            $table->morphs('laporan'); // Akan create laporan_id dan laporan_type

            // Admin yang melakukan update
            $table->foreignId('admin_id')
                  ->constrained('admins')
                  ->onDelete('cascade');

            // Status yang di-update
            $table->enum('status', [
                'menunggu',
                'diproses',
                'selesai',
                'ditolak'
            ]);

            // Umpan balik dari admin
            $table->text('umpan_balik');

            // Keterangan tambahan (opsional)
            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status');
    }
};
