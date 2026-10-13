<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, ?string $default = null): ?string
    {
        $all = Cache::remember('site_settings', 60, function () {
            return static::query()->pluck('value', 'key')->toArray();
        });

        return $all[$key] ?? $default;
    }

    public static function setMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }

    public static function allKeyed(): array
    {
        return Cache::remember('site_settings', 60, function () {
            return static::query()->pluck('value', 'key')->toArray();
        });
    }
}
