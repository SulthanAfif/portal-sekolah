<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ortu_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ortu_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->string('hubungan')->default('orang tua'); // ayah, ibu, wali
            $table->timestamps();

            $table->unique(['ortu_id', 'siswa_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ortu_siswa');
    }
};
