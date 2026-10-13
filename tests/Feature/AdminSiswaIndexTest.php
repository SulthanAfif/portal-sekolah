<?php

namespace Tests\Feature;

use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AdminSiswaIndexTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_student_filters_can_be_combined_by_grade_major_local_class_and_nis(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $matchingClass = Kelas::create(['nama' => 'XI IPA 2', 'tingkat' => 'XI', 'jurusan' => 'IPA']);
        $otherLocalClass = Kelas::create(['nama' => 'XI IPA 1', 'tingkat' => 'XI', 'jurusan' => 'IPA']);
        $otherMajorClass = Kelas::create(['nama' => 'XI IPS 2', 'tingkat' => 'XI', 'jurusan' => 'IPS']);
        $otherGradeClass = Kelas::create(['nama' => 'X IPA 2', 'tingkat' => 'X', 'jurusan' => 'IPA']);

        User::factory()->create([
            'name' => 'Siswa Sesuai Filter',
            'role' => 'siswa',
            'nis_nip' => '2023002',
            'kelas_id' => $matchingClass->id,
        ]);
        User::factory()->create(['name' => 'Siswa Lokal Lain', 'role' => 'siswa', 'kelas_id' => $otherLocalClass->id]);
        User::factory()->create(['name' => 'Siswa Jurusan Lain', 'role' => 'siswa', 'kelas_id' => $otherMajorClass->id]);
        User::factory()->create(['name' => 'Siswa Tingkat Lain', 'role' => 'siswa', 'kelas_id' => $otherGradeClass->id]);

        $response = $this->actingAs($admin)->get(route('admin.siswa.index', [
            'tingkat' => 'XI',
            'jurusan' => 'IPA',
            'lokal' => '2',
            'kelas_id' => $matchingClass->id,
            'nis' => '2023002',
        ]));

        $response->assertOk()
            ->assertSeeText('Siswa Sesuai Filter')
            ->assertDontSeeText('Siswa Lokal Lain')
            ->assertDontSeeText('Siswa Jurusan Lain')
            ->assertDontSeeText('Siswa Tingkat Lain')
            ->assertSeeText('1 siswa ditemukan');
    }

    public function test_class_filter_includes_students_attached_to_duplicate_class_records(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $firstClass = Kelas::create(['nama' => 'XI IPA 2', 'tingkat' => 'XI', 'jurusan' => 'IPA']);
        $duplicateClass = Kelas::create(['nama' => 'XI IPA 2', 'tingkat' => 'XI', 'jurusan' => 'IPA']);

        User::factory()->create(['name' => 'Siswa Kelas Pertama', 'role' => 'siswa', 'kelas_id' => $firstClass->id]);
        User::factory()->create(['name' => 'Siswa Kelas Duplikat', 'role' => 'siswa', 'kelas_id' => $duplicateClass->id]);

        $response = $this->actingAs($admin)->get(route('admin.siswa.index', [
            'kelas_id' => $firstClass->id,
        ]));

        $response->assertOk()
            ->assertSeeText('Siswa Kelas Pertama')
            ->assertSeeText('Siswa Kelas Duplikat')
            ->assertSee('value="'.$firstClass->id.'" selected', false)
            ->assertDontSee('value="'.$duplicateClass->id.'" >XI IPA 2</option>', false);
    }
}
