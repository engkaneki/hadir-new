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
        Schema::create('pengajuan_kk', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('no_hp');
            $table->string('nik_suami');
            $table->string('nama_suami');
            $table->string('nik_istri');
            $table->string('nama_istri');
            $table->date('tgl_pengajuan');
            $table->string('kk_suami')->nullable();
            $table->string('kk_istri')->nullable();
            $table->string('ktp_suami')->nullable();
            $table->string('ktp_istri')->nullable();
            $table->string('buku_nikah')->nullable();
            $table->string('buku_nikah_ortu')->nullable();
            $table->string('buku_nikah_ortu2')->nullable();
            $table->string('surat_pindah')->nullable();
            $table->string('lainnya')->nullable();
            $table->string('status');
            $table->string('petugas');
            $table->string('ket')->nullable();
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kk');
    }
};
