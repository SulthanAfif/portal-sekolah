<?php

namespace Tests\Feature;

use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class PengumumanControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_view_published_announcements(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $published = $this->createAnnouncement($admin, 'Informasi sekolah', true, 'semua');
        $unpublished = $this->createAnnouncement($admin, 'Draft internal', false, 'semua');

        $response = $this->actingAs($admin)->get('/pengumuman');

        $response->assertOk()
            ->assertViewIs('pengumuman.index')
            ->assertViewHas('pengumumans', function ($announcements) use ($published, $unpublished): bool {
                return $announcements->contains('id', $published->id)
                    && ! $announcements->contains('id', $unpublished->id);
            });
    }

    public function test_user_cannot_view_an_announcement_for_another_role(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $guru = User::factory()->create(['role' => 'guru']);
        $announcement = $this->createAnnouncement($guru, 'Informasi guru', true, 'guru');

        $response = $this->actingAs($siswa)->get(route('pengumuman.show', $announcement));

        $response->assertNotFound();
    }

    public function test_user_can_view_a_published_announcement_for_their_role(): void
    {
        $siswa = User::factory()->create(['role' => 'siswa']);
        $announcement = $this->createAnnouncement($siswa, 'Informasi siswa', true, 'siswa');

        $response = $this->actingAs($siswa)->get(route('pengumuman.show', $announcement));

        $response->assertOk()
            ->assertViewIs('pengumuman.show')
            ->assertViewHas('pengumuman', $announcement);
    }

    private function createAnnouncement(User $creator, string $title, bool $published, string $target): Pengumuman
    {
        return Pengumuman::create([
            'judul' => $title,
            'isi' => "Isi {$title}",
            'target' => $target,
            'user_id' => $creator->id,
            'is_published' => $published,
            'published_at' => $published ? now() : null,
        ]);
    }
}
