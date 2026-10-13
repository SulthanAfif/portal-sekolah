<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $kelas  = Kelas::where('nama', 'X IPA 1')->first();
        $mapels = Mapel::all();
        $gurus  = User::where('role', 'guru')->get();

        if (!$kelas || $mapels->isEmpty()) {
            return;
        }

        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];

        $jam = [
            ['07:00', '07:45'],
            ['07:45', '08:30'],
            ['08:30', '09:15'],
            ['09:30', '10:15'],
            ['10:15', '11:00'],
        ];

        $index = 0;
        foreach ($hariList as $hari) {
            foreach ($jam as $j) {
                $mapel = $mapels[$index % $mapels->count()];
                $guru  = $gurus[$index % $gurus->count()];

                Jadwal::firstOrCreate(
                    [
                        'kelas_id'  => $kelas->id,
                        'hari'      => $hari,
                        'jam_mulai' => $j[0],
                    ],
                    [
                        'mapel_id'    => $mapel->id,
                        'guru_id'     => $guru->id,
                        'jam_selesai' => $j[1],
                        'ruangan'     => 'R.' . rand(101, 110),
                    ],
                );

                $index++;
            }
        }
    }
}
