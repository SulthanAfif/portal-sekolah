<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama', 'tingkat', 'jurusan', 'wali_kelas_id'];

    public function siswa()
    {
        return $this->hasMany(User::class)->where('role', 'siswa');
    }

    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
