<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = [
        'kelas_id', 'mapel_id', 'guru_id', 'hari',
        'jam_mulai', 'jam_selesai', 'ruangan',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }
}
