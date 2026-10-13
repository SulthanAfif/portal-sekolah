<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_admin_dashboard_renders_all_administration_navigation_links(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('dashboard'));

        $response->assertOk()
            ->assertSee('Pengaturan Situs')
            ->assertSee('Persetujuan Cuti')
            ->assertSee('Kelola Struktur')
            ->assertSee('Ekspor Data');
    }

    public function test_site_settings_are_available_to_admins(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.settings.edit'))
            ->assertOk()
            ->assertViewIs('admin.settings.edit');
    }

    public function test_site_settings_are_forbidden_to_tata_usaha_users(): void
    {
        $tu = User::factory()->create(['role' => 'tu']);

        $this->actingAs($tu)
            ->get(route('admin.settings.edit'))
            ->assertForbidden();
    }
}
