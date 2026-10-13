<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('no_hp');
            }
        });

        if (! Schema::hasTable('struktur_anggota')) {
            Schema::create('struktur_anggota', function (Blueprint $table) {
                $table->id();
                $table->string('jabatan');
                $table->string('nama');
                $table->string('foto')->nullable();
                $table->unsignedInteger('urutan')->default(0);
                $table->string('parent_jabatan')->nullable(); // untuk hierarki sederhana
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('pengajuan_cuti')) {
            Schema::create('pengajuan_cuti', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->string('jenis', 50); // cuti, izin, sakit, dinas
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->text('alasan');
                $table->string('status', 20)->default('pending'); // pending, approved, rejected
                $table->text('catatan_admin')->nullable();
                $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cuti');
        Schema::dropIfExists('struktur_anggota');
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'profile_photo')) {
                $table->dropColumn('profile_photo');
            }
        });
    }
};
