<?php

namespace Database\Seeders;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengumumanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $data = [
            [
                'judul' => 'Libur Semester Ganjil 2025/2026',
                'isi'   => 'Diberitahukan kepada seluruh siswa bahwa libur semester ganjil dimulai tanggal 15 Desember 2025 sampai 5 Januari 2026. Kegiatan belajar mengajar dimulai kembali pada 6 Januari 2026.',
                'target'=> 'semua',
            ],
            [
                'judul' => 'Jadwal Ujian Tengah Semester',
                'isi'   => 'Ujian Tengah Semester (UTS) akan dilaksanakan pada tanggal 20-25 Oktober 2025. Seluruh siswa diharapkan mempersiapkan diri dengan baik.',
                'target'=> 'siswa',
            ],
            [
                'judul' => 'Rapat Koordinasi Guru',
                'isi'   => 'Diharapkan kehadiran seluruh guru pada rapat koordinasi yang akan dilaksanakan hari Sabtu, 12 Oktober 2025 pukul 09.00 di Aula Sekolah.',
                'target'=> 'guru',
            ],
        ];

        foreach ($data as $item) {
            Pengumuman::firstOrCreate(
                ['judul' => $item['judul']],
                [
                    'isi'          => $item['isi'],
                    'target'       => $item['target'],
                    'user_id'      => $admin->id,
                    'is_published' => true,
                    'published_at' => now(),
                ],
            );
        }
    }
}
