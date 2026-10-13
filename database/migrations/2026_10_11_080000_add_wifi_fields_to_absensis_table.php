<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->string('ip_address', 45)->nullable()->after('dicatat_oleh');
            $table->enum('metode', ['self', 'manual'])->default('manual')->after('ip_address');
            $table->timestamp('waktu_absen')->nullable()->after('metode');
        });
    }

    public function down(): void
    {
        Schema::table('absensis', function (Blueprint $table) {
            $table->dropColumn(['ip_address', 'metode', 'waktu_absen']);
        });
    }
};
