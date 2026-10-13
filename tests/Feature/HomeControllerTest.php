<?php

namespace Tests\Feature;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_homepage_renders_announcement_with_published_timestamp(): void
    {
        $user = User::factory()->create();

        Pengumuman::create([
            'judul' => 'Informasi sekolah',
            'isi' => 'Informasi terbaru untuk masyarakat umum.',
            'target' => 'semua',
            'user_id' => $user->id,
            'is_published' => true,
            'published_at' => '2026-10-11 08:00:00',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('11 Oct 2026');
    }
}
