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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('mapel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kelas_id')->constrained()->cascadeOnDelete();
            $table->string('jenis'); // UTS, UAS, Tugas, Harian
            $table->decimal('nilai', 5, 2);
            $table->string('semester'); // Ganjil / Genap
            $table->string('tahun_ajaran'); // 2025/2026
            $table->foreignId('guru_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};