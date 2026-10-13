<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kelas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ===================== ADMIN =====================
        User::firstOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name'      => 'Administrator',
                'password'  => Hash::make('password'),
                'role'      => 'admin',
                'nis_nip'   => 'ADM001',
                'no_hp'     => '081234567890',
                'is_active' => true,
            ],
        );

        User::firstOrCreate(
            ['email' => 'tu@sekolah.sch.id'],
            [
                'name'      => 'Tata Usaha',
                'password'  => Hash::make('password'),
                'role'      => 'tu',
                'nis_nip'   => 'TU001',
                'no_hp'     => '081234567891',
                'is_active' => true,
            ],
        );

        // ===================== GURU =====================
        $gurus = [
            ['name' => 'Budi Santoso, S.Pd',     'email' => 'budi@sekolah.sch.id',    'nis_nip' => '198001012005011001'],
            ['name' => 'Siti Aminah, S.Pd',      'email' => 'siti@sekolah.sch.id',    'nis_nip' => '198205152006012002'],
            ['name' => 'Ahmad Fauzi, M.Pd',      'email' => 'ahmad@sekolah.sch.id',   'nis_nip' => '197812202004011003'],
            ['name' => 'Dewi Lestari, S.Pd',     'email' => 'dewi@sekolah.sch.id',    'nis_nip' => '198903102010012004'],
            ['name' => 'Rudi Hartono, S.Pd',     'email' => 'rudi@sekolah.sch.id',    'nis_nip' => '198506252008011005'],
        ];

        foreach ($gurus as $guru) {
            User::firstOrCreate(
                ['email' => $guru['email']],
                [
                    'name'      => $guru['name'],
                    'password'  => Hash::make('password'),
                    'role'      => 'guru',
                    'nis_nip'   => $guru['nis_nip'],
                    'no_hp'     => '08' . rand(1000000000, 9999999999),
                    'is_active' => true,
                ],
            );
        }

        // Assign wali kelas (ambil guru pertama sebagai contoh)
        $guruPertama = User::where('role', 'guru')->first();
        Kelas::where('nama', 'X IPA 1')->update(['wali_kelas_id' => $guruPertama->id]);
        Kelas::where('nama', 'XI IPA 1')->update(['wali_kelas_id' => User::where('role', 'guru')->skip(1)->first()->id]);

        // ===================== SISWA =====================
        $kelasList = Kelas::all();

        $siswaData = [
            // X IPA 1
            ['name' => 'Andi Pratama',    'nis' => '2024001', 'kelas' => 'X IPA 1'],
            ['name' => 'Bunga Citra',     'nis' => '2024002', 'kelas' => 'X IPA 1'],
            ['name' => 'Cahyo Nugroho',   'nis' => '2024003', 'kelas' => 'X IPA 1'],
            ['name' => 'Dina Marlina',    'nis' => '2024004', 'kelas' => 'X IPA 1'],
            ['name' => 'Eko Saputra',     'nis' => '2024005', 'kelas' => 'X IPA 1'],

            // XI IPA 1
            ['name' => 'Fajar Rahman',    'nis' => '2023001', 'kelas' => 'XI IPA 1'],
            ['name' => 'Gita Savitri',    'nis' => '2023002', 'kelas' => 'XI IPA 1'],
            ['name' => 'Hendra Wijaya',   'nis' => '2023003', 'kelas' => 'XI IPA 1'],
            ['name' => 'Indah Permata',   'nis' => '2023004', 'kelas' => 'XI IPA 1'],
            ['name' => 'Joko Susilo',     'nis' => '2023005', 'kelas' => 'XI IPA 1'],

            // XII IPA 1
            ['name' => 'Kartika Sari',    'nis' => '2022001', 'kelas' => 'XII IPA 1'],
            ['name' => 'Lukman Hakim',    'nis' => '2022002', 'kelas' => 'XII IPA 1'],
            ['name' => 'Maya Putri',      'nis' => '2022003', 'kelas' => 'XII IPA 1'],
        ];

        foreach ($siswaData as $siswa) {
            $kelas = $kelasList->firstWhere('nama', $siswa['kelas']);
            $email = strtolower(str_replace(' ', '.', $siswa['name'])) . '@siswa.sch.id';

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'      => $siswa['name'],
                    'password'  => Hash::make('password'),
                    'role'      => 'siswa',
                    'nis_nip'   => $siswa['nis'],
                    'kelas_id'  => $kelas?->id,
                    'no_hp'     => '08' . rand(1000000000, 9999999999),
                    'is_active' => true,
                ],
            );

            if ($kelas && $user->kelas_id !== $kelas->id) {
                $user->update(['kelas_id' => $kelas->id]);
            }
        }
    }
}
