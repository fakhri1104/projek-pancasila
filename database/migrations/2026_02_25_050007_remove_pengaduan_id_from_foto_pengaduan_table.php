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
        if (Schema::hasColumn('foto_pengaduan', 'pengaduan_id')) {
            Schema::table('foto_pengaduan', function (Blueprint $table) {
                $table->dropForeign(['pengaduan_id']);
                $table->dropColumn('pengaduan_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // The legacy pengaduans table is no longer part of the schema.
    }
};
