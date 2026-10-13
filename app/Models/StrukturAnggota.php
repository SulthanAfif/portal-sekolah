<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StrukturAnggota extends Model
{
    protected $table = 'struktur_anggota';

    protected $fillable = ['jabatan', 'nama', 'nip', 'is_active', 'foto', 'urutan', 'parent_jabatan'];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function fotoUrl(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return asset('storage/'.$this->foto);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->nama).'&background=4f46e5&color=fff&size=128';
    }
}
