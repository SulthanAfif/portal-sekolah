<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            ['nama' => 'X IPA 1',  'tingkat' => 'X',   'jurusan' => 'IPA'],
            ['nama' => 'X IPA 2',  'tingkat' => 'X',   'jurusan' => 'IPA'],
            ['nama' => 'X IPS 1',  'tingkat' => 'X',   'jurusan' => 'IPS'],
            ['nama' => 'XI IPA 1', 'tingkat' => 'XI',  'jurusan' => 'IPA'],
            ['nama' => 'XI IPA 2', 'tingkat' => 'XI',  'jurusan' => 'IPA'],
            ['nama' => 'XI IPS 1', 'tingkat' => 'XI',  'jurusan' => 'IPS'],
            ['nama' => 'XII IPA 1','tingkat' => 'XII', 'jurusan' => 'IPA'],
            ['nama' => 'XII IPS 1','tingkat' => 'XII', 'jurusan' => 'IPS'],
        ];

        foreach ($kelas as $item) {
            Kelas::firstOrCreate(
                ['nama' => $item['nama']],
                ['tingkat' => $item['tingkat'], 'jurusan' => $item['jurusan']],
            );
        }
    }
}
