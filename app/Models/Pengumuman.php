<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = ['judul', 'isi', 'target', 'user_id', 'is_published', 'published_at'];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
