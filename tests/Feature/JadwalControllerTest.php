<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JadwalControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guru_can_view_their_schedule(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $response = $this->actingAs($guru)->get('/jadwal');

        $response->assertOk()->assertViewIs('jadwal.guru');
    }

    public function test_siswa_can_view_their_schedule(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($siswa)->get('/jadwal');

        $response->assertOk()->assertViewIs('jadwal.siswa');
    }

    public function test_admin_can_view_all_schedules(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/jadwal');

        $response->assertOk()->assertViewIs('admin.jadwal.index');
    }
}
