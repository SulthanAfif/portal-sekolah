<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nis_nip', 'no_hp',
        'kelas_id', 'is_active', 'profile_completed_at', 'profile_photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'profile_completed_at' => 'datetime',
        ];
    }

    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function absensis() { return $this->hasMany(Absensi::class, 'siswa_id'); }
    public function nilais() { return $this->hasMany(Nilai::class, 'siswa_id'); }

    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isTu(): bool { return $this->role === 'tu'; }
    public function isGuru(): bool { return $this->role === 'guru'; }
    public function isSiswa(): bool { return $this->role === 'siswa'; }

    /** Admin + TU: data master sekolah */
    public function canManageData(): bool
    {
        return in_array($this->role, ['admin', 'tu'], true);
    }

    /** Hanya Admin: pengaturan website */
    public function canManageSite(): bool
    {
        return $this->role === 'admin';
    }

    /** Alias lama */
    public function profilePhotoUrl(): string
    {
        if ($this->profile_photo) {
            return asset('storage/'.$this->profile_photo);
        }
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=4f46e5&color=fff&size=128';
    }

    public function pengajuanCutis()
    {
        return $this->hasMany(PengajuanCuti::class);
    }

    public function canManage(): bool
    {
        return $this->canManageData();
    }
}
