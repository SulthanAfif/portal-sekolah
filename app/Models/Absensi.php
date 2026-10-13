<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $fillable = [
        'siswa_id',
        'kelas_id',
        'tanggal',
        'status',
        'keterangan',
        'dicatat_oleh',
        'ip_address',
        'metode',
        'waktu_absen',
    ];

    protected function casts(): array
    {
        return [
            'tanggal'     => 'date',
            'waktu_absen' => 'datetime',
        ];
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dicatat_oleh');
    }
}
