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
        Schema::create('pengajuan_surat_pindah', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('nik_pelapor');
            $table->string('nama_pelapor');
            $table->string('no_hp');
            $table->string('alamat_old');
            $table->string('alamat_new');
            $table->date('tgl_pengajuan');
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('surat_desa')->nullable();
            $table->string('status');
            $table->string('petugas');
            $table->string('ket')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_surat_pindah');
    }
};
