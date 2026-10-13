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
        Schema::table('struktur_anggota', function (Blueprint $table) {
            $table->string('nip')->nullable()->after('nama');
            $table->boolean('is_active')->default(true)->after('nip');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('struktur_anggota', function (Blueprint $table) {
            $table->dropColumn(['nip', 'is_active']);
        });
    }
};
