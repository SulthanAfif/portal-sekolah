<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus user ortu
        DB::table('users')->where('role', 'ortu')->delete();

        if (Schema::hasTable('ortu_siswa')) {
            Schema::dropIfExists('ortu_siswa');
        }

        // Ubah enum role (MySQL)
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'siswa', 'tu') DEFAULT 'siswa'");
        } catch (\Throwable $e) {
            // SQLite / driver lain: skip
        }
    }

    public function down(): void
    {
        try {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'guru', 'siswa', 'ortu') DEFAULT 'siswa'");
        } catch (\Throwable $e) {
        }
    }
};
