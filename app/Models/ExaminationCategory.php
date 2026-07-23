<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ExaminationCategory extends Model
{
    protected $fillable = [
        'name',
        'code',
        'name_ar',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    const CACHE_KEY = 'examination_categories.with_levels';

    public function levels()
    {
        return $this->hasMany(ExaminationLevel::class)->orderBy('sort_order');
    }

    public function activeLevels()
    {
        return $this->levels()->where('is_active', true);
    }

    /**
     * All active categories with their active levels, cached, ready to
     * feed any dropdown in the system. This is what every blade view
     * should use instead of hardcoded PLE/UCE/UACE options.
     */
    public static function allWithLevels()
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return self::where('is_active', true)
                ->orderBy('sort_order')
                ->with('activeLevels')
                ->get();
        });
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    protected static function booted()
    {
        static::saved(fn () => self::flush());
        static::deleted(fn () => self::flush());
    }
}
