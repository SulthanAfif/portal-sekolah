<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'siswa_id', 'mapel_id', 'kelas_id', 'guru_id',
        'jenis', 'nilai', 'semester', 'tahun_ajaran',
        'status', 'catatan',
    ];

    public function siswa() { return $this->belongsTo(User::class, 'siswa_id'); }
    public function mapel() { return $this->belongsTo(Mapel::class); }
    public function kelas() { return $this->belongsTo(Kelas::class); }
    public function guru() { return $this->belongsTo(User::class, 'guru_id'); }
}
