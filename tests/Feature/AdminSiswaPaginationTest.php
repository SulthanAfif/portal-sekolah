<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminSiswaPaginationTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_student_list_uses_bootstrap_pagination_instead_of_oversized_tailwind_icons(): void
    {
        /** @var User $admin */
        $admin = User::factory()->create(['role' => 'admin']);

        User::factory()->count(16)->create(['role' => 'siswa']);

        $response = $this->actingAs($admin)->get(route('admin.siswa.index'));

        $response->assertOk()
            ->assertSee('<ul class="pagination"', false)
            ->assertDontSee('inline-flex rtl:flex-row-reverse', false)
            ->assertDontSee('viewBox="0 0 20 20"', false);
    }
}
