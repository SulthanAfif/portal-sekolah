<?php

namespace Tests\Feature;

use App\Models\StrukturAnggota;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminStrukturTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_can_create_structure_member_with_educator_id_and_status(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.struktur.store'), [
            'jabatan' => 'Kepala Sekolah',
            'nama' => 'Nazar S.Pd.',
            'nip' => '198001012005011001',
            'is_active' => '1',
        ]);

        $response->assertRedirect();
        $member = StrukturAnggota::where('nip', '198001012005011001')->firstOrFail();
        $this->assertTrue($member->is_active);
    }

    public function test_admin_can_change_structure_member_status_and_educator_id(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);
        /** @var StrukturAnggota $member */
        $member = StrukturAnggota::create([
            'jabatan' => 'Guru',
            'nama' => 'Siti',
            'nip' => '123',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.struktur.update', $member), [
            'jabatan' => 'Guru',
            'nama' => 'Siti',
            'nip' => '456',
            'is_active' => '0',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('struktur_anggota', [
            'id' => $member->id,
            'nip' => '456',
            'is_active' => 0,
        ]);
    }

    public function test_public_homepage_shows_only_active_structure_members(): void
    {
        $active = StrukturAnggota::create([
            'jabatan' => 'Kepala Sekolah',
            'nama' => 'Pendidik Aktif',
            'is_active' => true,
        ]);
        StrukturAnggota::create([
            'jabatan' => 'Guru',
            'nama' => 'Pendidik Nonaktif',
            'is_active' => false,
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee($active->nama)
            ->assertDontSee('Pendidik Nonaktif');
    }

    public function test_structure_photo_url_uses_public_storage_and_falls_back_when_photo_is_missing(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('struktur/kepala.png', 'image-content');
        $member = StrukturAnggota::create([
            'jabatan' => 'Kepala Sekolah',
            'nama' => 'Nazar',
            'foto' => 'struktur/kepala.png',
            'is_active' => true,
        ]);

        $this->assertStringContainsString('/storage/struktur/kepala.png', $member->fotoUrl());

        $member->foto = 'struktur/tidak-ada.png';
        $this->assertStringContainsString('ui-avatars.com/api/', $member->fotoUrl());
    }

    public function test_admin_structure_page_displays_educator_id_and_status_fields(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.struktur.index'))
            ->assertOk()
            ->assertSee('NIP/ID Pendidik')
            ->assertSee('Status')
            ->assertSee('Nonaktif')
            ->assertSee('data-photo-cropper', false)
            ->assertSee('data-photo-zoom', false)
            ->assertSee('Geser gambar di dalam kotak');
    }
}
