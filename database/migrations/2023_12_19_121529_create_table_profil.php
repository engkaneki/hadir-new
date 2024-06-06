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
        Schema::create('table_profil', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('foto')->nullable();
            $table->string('kode_user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_profil');
    }
};
