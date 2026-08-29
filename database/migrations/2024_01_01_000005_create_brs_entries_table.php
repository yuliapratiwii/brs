<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brs_entries', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('kategori');
            $table->date('tanggal_rilis');
            $table->string('periode_rilis');
            $table->string('jumlah_terbitan')->nullable();
            $table->unsignedInteger('tahun_pertama_terbit')->nullable();
            $table->string('penanggung_jawab');
            $table->unsignedInteger('no_urut')->default(0);
            $table->string('nomor_brs')->nullable();
            $table->timestamps();

            $table->index('tanggal_rilis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brs_entries');
    }
};
