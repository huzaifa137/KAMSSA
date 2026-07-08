<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $table = 'system_settings';

    protected $fillable = [
        'system_name',
        'system_name_ar',
        'short_name',
        'tagline',
        'logo_path',
        'favicon_path',
        'letterhead_path',
        'address',
        'phone',
        'email',
        'website',
        'footer_text',
        'portal_welcome_text',
    ];

    const CACHE_KEY = 'system_settings.current';

    /**
     * Return the single settings row, creating a sensible default one
     * the first time the app runs (so nothing breaks if the module
     * hasn't been configured for a given client yet).
     */
    public static function current(): self
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::query()->first() ?? self::create([
                'system_name' => 'Kampala Integrated Secondary Schools Examination',
                'short_name'  => 'KAMSSA',
            ]);
        });
    }

    /**
     * Clear the cached settings. Call this any time the row is updated
     * so the change is reflected everywhere immediately.
     */
    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted()
    {
        static::saved(fn () => self::flush());
        static::deleted(fn () => self::flush());
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo_path
            ? asset('storage/' . $this->logo_path)
            : asset('assets/images/brand/logo.png');
    }

    public function getFaviconUrlAttribute(): string
    {
        return $this->favicon_path
            ? asset('storage/' . $this->favicon_path)
            : asset('assets/images/brand/logo.png');
    }
}
