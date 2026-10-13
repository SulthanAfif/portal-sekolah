<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\KelasController as AdminKelasController;
use App\Http\Controllers\Admin\MapelController as AdminMapelController;
use App\Http\Controllers\Admin\PengumumanController as AdminPengumumanController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\NilaiController as AdminNilaiController;
use App\Http\Controllers\Admin\CutiController as AdminCutiController;
use App\Http\Controllers\Admin\StrukturController as AdminStrukturController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\ExportController as AdminExportController;
use App\Http\Controllers\Guru\CutiController as GuruCutiController;
use App\Http\Controllers\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Middleware\EnsureSiteAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil-sekolah', [HomeController::class, 'profilSekolah'])->name('profil-sekolah');

// Chatbot publik — bisa diakses tanpa login
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])->name('chatbot.chat');
Route::post('/chatbot/reset', [ChatbotController::class, 'reset'])->name('chatbot.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/biodata', [BiodataController::class, 'show'])->name('biodata.show');
    Route::patch('/biodata', [BiodataController::class, 'update'])->name('biodata.update');
    Route::post('/biodata/lanjut', [BiodataController::class, 'continueToDashboard'])->name('biodata.continue');


    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    Route::post('/absensi/checkin', [AbsensiController::class, 'checkIn'])->middleware('school.wifi')->name('absensi.checkin');
    Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    Route::post('/absensi/bulk', [AbsensiController::class, 'bulkStore'])->name('absensi.bulk');

    Route::get('/pengumuman', [PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::get('/pengumuman/{pengumuman}', [PengumumanController::class, 'show'])->name('pengumuman.show');

    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');

    Route::get('/guru/nilai', [GuruNilaiController::class, 'index'])->name('guru.nilai.index');
    Route::get('/guru/nilai/create', [GuruNilaiController::class, 'create'])->name('guru.nilai.create');
    Route::post('/guru/nilai', [GuruNilaiController::class, 'store'])->name('guru.nilai.store');
    Route::delete('/guru/nilai/{nilai}', [GuruNilaiController::class, 'destroy'])->name('guru.nilai.destroy');

    Route::get('/guru/cuti', [GuruCutiController::class, 'index'])->name('guru.cuti.index');
    Route::get('/guru/cuti/create', [GuruCutiController::class, 'create'])->name('guru.cuti.create');
    Route::post('/guru/cuti', [GuruCutiController::class, 'store'])->name('guru.cuti.store');
    Route::delete('/guru/cuti/{cuti}', [GuruCutiController::class, 'destroy'])->name('guru.cuti.destroy');

    Route::get('/siswa/nilai', [SiswaNilaiController::class, 'index'])->name('siswa.nilai.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== Admin / TU — kelola semua =====
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('siswa', AdminSiswaController::class)->except(['show']);
        Route::resource('guru', AdminGuruController::class)->except(['show']);
        Route::resource('kelas', AdminKelasController::class)->except(['show']);
        Route::resource('mapel', AdminMapelController::class)->except(['show']);
        Route::resource('pengumuman', AdminPengumumanController::class)->except(['show']);
        Route::resource('jadwal', AdminJadwalController::class)->except(['show']);
        Route::get('settings', [SiteSettingController::class, 'edit'])
            ->middleware(EnsureSiteAdmin::class)
            ->name('settings.edit');
        Route::put('settings', [SiteSettingController::class, 'update'])
            ->middleware(EnsureSiteAdmin::class)
            ->name('settings.update');
        Route::get('nilai', [AdminNilaiController::class, 'index'])->name('nilai.index');
        Route::get('nilai/create', [AdminNilaiController::class, 'create'])->name('nilai.create');
        Route::post('nilai', [AdminNilaiController::class, 'store'])->name('nilai.store');
        Route::delete('nilai/{nilai}', [AdminNilaiController::class, 'destroy'])->name('nilai.destroy');
        Route::get('cuti', [AdminCutiController::class, 'index'])->name('cuti.index');
        Route::patch('cuti/{cuti}', [AdminCutiController::class, 'update'])->name('cuti.update');
        Route::get('struktur', [AdminStrukturController::class, 'index'])->name('struktur.index');
        Route::post('struktur', [AdminStrukturController::class, 'store'])->name('struktur.store');
        Route::patch('struktur/{struktur}', [AdminStrukturController::class, 'update'])->name('struktur.update');
        Route::delete('struktur/{struktur}', [AdminStrukturController::class, 'destroy'])->name('struktur.destroy');
        Route::get('export/siswa', [AdminExportController::class, 'siswa'])->name('export.siswa');
    });
});

require __DIR__.'/auth.php';
