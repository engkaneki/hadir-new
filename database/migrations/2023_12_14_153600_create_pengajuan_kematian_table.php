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
        Schema::create('pengajuan_kematian', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('no_hp');
            $table->string('nik_pelapor');
            $table->string('nama_pelapor');
            $table->string('nik_mati');
            $table->string('nama_mati');
            $table->string('ktp_pelapor')->nullable();
            $table->string('ktp_mati')->nullable();
            $table->string('kk')->nullable();
            $table->string('surat_kuning')->nullable();
            $table->string('surat_mati_desa')->nullable();
            $table->string('formulir_mati')->nullable();
            $table->date('tgl_pengajuan');
            $table->string('petugas');
            $table->string('status');
            $table->string('ket')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_kematian');
    }
};
