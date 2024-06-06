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
        Schema::create('pengajuan_akta_lahir', function (Blueprint $table) {
            $table->id();
            $table->string('noreg');
            $table->string('no_hp');
            $table->string('no_kk');
            $table->string('nama_anak');
            $table->string('jk_anak');
            $table->date('tgl_lahir');
            $table->string('jenis_kelahiran');
            $table->string('anak_ke');
            $table->string('berat');
            $table->string('panjang');
            $table->string('nik_ibu');
            $table->string('nama_ibu');
            $table->string('nik_ayah');
            $table->string('nama_ayah');
            $table->string('surat_pengantar')->nullable();
            $table->string('surat_lahir')->nullable();
            $table->string('kk')->nullable();
            $table->string('ktp_ayah')->nullable();
            $table->string('ktp_ibu')->nullable();
            $table->string('buku_nikah')->nullable();
            $table->date('tgl_pengajuan');
            $table->string('petugas');
            $table->string('status');
            $table->text('ket')->nullable();
            $table->text('detail')->nullable();
            $table->string('lainnya')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_akta_lahir');
    }
};
