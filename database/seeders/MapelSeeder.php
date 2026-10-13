<?php

namespace Database\Seeders;

use App\Models\Mapel;
use App\Models\User;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = User::where('role', 'guru')->get();

        $mapels = [
            ['nama' => 'Matematika',           'kode' => 'MTK'],
            ['nama' => 'Bahasa Indonesia',     'kode' => 'BIN'],
            ['nama' => 'Bahasa Inggris',       'kode' => 'BIG'],
            ['nama' => 'Fisika',               'kode' => 'FIS'],
            ['nama' => 'Kimia',                'kode' => 'KIM'],
            ['nama' => 'Biologi',              'kode' => 'BIO'],
            ['nama' => 'Sejarah',              'kode' => 'SEJ'],
            ['nama' => 'Pendidikan Agama',     'kode' => 'PAI'],
            ['nama' => 'Pendidikan Jasmani',   'kode' => 'PJOK'],
            ['nama' => 'Seni Budaya',          'kode' => 'SEN'],
        ];

        foreach ($mapels as $index => $mapel) {
            Mapel::firstOrCreate(
                ['kode' => $mapel['kode']],
                [
                    'nama' => $mapel['nama'],
                    'guru_id' => $gurus[$index % $gurus->count()]->id ?? null,
                ],
            );
        }
    }
}
