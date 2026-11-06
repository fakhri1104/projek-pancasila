<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foto_pengaduan', function (Blueprint $table) {
            $table->id();

            $table->foreignId('aspirasi_id')
                ->nullable()
                ->constrained('aspirasis')
                ->onDelete('cascade');

            $table->string('url_foto', 500);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('foto_pengaduan');
    }
};
