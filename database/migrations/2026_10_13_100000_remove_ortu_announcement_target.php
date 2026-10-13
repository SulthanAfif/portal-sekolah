<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pengumumans') || ! Schema::hasColumn('pengumumans', 'target')) {
            return;
        }

        DB::table('pengumumans')->where('target', 'ortu')->delete();

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `pengumumans` MODIFY `target` ENUM('semua', 'siswa', 'guru') NOT NULL DEFAULT 'semua'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql'
            && Schema::hasTable('pengumumans')
            && Schema::hasColumn('pengumumans', 'target')) {
            DB::statement("ALTER TABLE `pengumumans` MODIFY `target` ENUM('semua', 'siswa', 'guru', 'ortu') NOT NULL DEFAULT 'semua'");
        }
    }
};
