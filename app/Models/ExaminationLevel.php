<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ExaminationLevel extends Model
{
    protected $fillable = [
        'examination_category_id',
        'name',
        'name_ar',
        'short_code',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ExaminationCategory::class, 'examination_category_id');
    }

    /**
     * Flat, cached list of every active level across every category.
     * Handy for places that used to loop over a hardcoded
     * ['UCE' => 'O-LEVEL', 'UACE' => 'A-LEVEL'] array.
     */
    public static function activeFlat()
    {
        return Cache::rememberForever('examination_levels.active_flat', function () {
            return self::where('is_active', true)->orderBy('sort_order')->get();
        });
    }

    public static function findByCode(string $code): ?self
    {
        return self::activeFlat()->firstWhere('short_code', $code);
    }

    public static function flush(): void
    {
        Cache::forget('examination_levels.active_flat');
        \App\Models\ExaminationCategory::flush();
    }

    protected static function booted()
    {
        static::saved(fn () => self::flush());
        static::deleted(fn () => self::flush());
    }
}
