<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        $defaults = [
            'school_name' => 'SMA Negeri Contoh',
            'school_address' => 'Jl. Pendidikan No. 123, Jakarta',
            'school_phone' => '(021) 1234567',
            'school_email' => 'tu@sekolah.sch.id',
            'school_hours' => 'Senin - Jumat, 07.00 - 15.00',
            'school_visi' => 'Menjadi sekolah unggul yang menghasilkan lulusan berkarakter, berprestasi, dan siap menghadapi tantangan global.',
            'school_misi' => "Menyelenggarakan pendidikan berkualitas berbasis teknologi.\nMengembangkan karakter siswa yang beriman, berilmu, dan berbudaya.\nMeningkatkan kompetensi guru dan tenaga kependidikan.\nMembangun kerja sama dengan masyarakat.",
            'school_kepala' => 'Drs. Ahmad Fauzi, M.Pd.',
            'school_struktur' => "Kepala Sekolah\nWakil Kurikulum\nWakil Kesiswaan\nWakil Sarana\nKepala TU\nWali Kelas\nGuru Mapel",
        ];
        foreach ($defaults as $k => $v) {
            DB::table('site_settings')->insert([
                'key' => $k, 'value' => $v,
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
