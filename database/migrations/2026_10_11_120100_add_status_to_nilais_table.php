<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            if (! Schema::hasColumn('nilais', 'status')) {
                $table->string('status', 20)->default('submitted')->after('tahun_ajaran');
                // draft | submitted | approved
            }
            if (! Schema::hasColumn('nilais', 'catatan')) {
                $table->string('catatan')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('nilais', function (Blueprint $table) {
            $table->dropColumn(['status', 'catatan']);
        });
    }
};
