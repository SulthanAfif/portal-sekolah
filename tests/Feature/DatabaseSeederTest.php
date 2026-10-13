<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_running_database_seeder_twice_does_not_duplicate_seeded_records(): void
    {
        $this->seed(DatabaseSeeder::class);

        User::where('email', 'hendra.wijaya@siswa.sch.id')->update(['kelas_id' => null]);

        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 20);
        $this->assertDatabaseCount('kelas', 8);
        $this->assertDatabaseCount('mapels', 10);
        $this->assertDatabaseCount('pengumumans', 4);
        $this->assertDatabaseCount('jadwals', 25);

        $student = User::where('email', 'andi.pratama@siswa.sch.id')->firstOrFail();
        $kelas = Kelas::where('nama', 'X IPA 1')->firstOrFail();
        $hendra = User::where('email', 'hendra.wijaya@siswa.sch.id')->firstOrFail();
        $kelasXi = Kelas::where('nama', 'XI IPA 1')->firstOrFail();

        $this->assertSame($kelas->id, $student->kelas_id);
        $this->assertSame($kelasXi->id, $hendra->kelas_id);
    }
}
