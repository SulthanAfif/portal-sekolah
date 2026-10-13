<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class GuruNilaiControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guru_can_view_their_grades(): void
    {
        $guru = User::factory()->create(['role' => 'guru']);

        $this->actingAs($guru)
            ->get(route('guru.nilai.index'))
            ->assertOk()
            ->assertViewIs('guru.nilai.index');
    }

    public function test_non_guru_cannot_view_the_guru_grades_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('guru.nilai.index'))
            ->assertForbidden();
    }
}
