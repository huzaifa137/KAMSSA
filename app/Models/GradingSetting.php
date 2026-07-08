<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradingSetting extends Model
{
    protected $table = 'grading_settings';

    protected $fillable = [
        'category',
        'grade',
        'from_mark',
        'to_mark',
        'comment',
        'type',
        'weight',
        'sort_order',
    ];

    /**
     * Get all grades for a given category and type, ordered by sort_order.
     */
    public static function getGrades(string $category, string $type): \Illuminate\Support\Collection
    {
        return self::where('category', $category)
            ->where('type', $type)
            ->orderBy('sort_order')
            ->orderBy('weight')
            ->get();
    }

    /**
     * Get the matching grade row for a given score, category and type.
     */
    public static function getGrade(float $score, string $type, string $category): ?self
    {
        return self::where('category', $category)
            ->where('type', $type)
            ->where('from_mark', '<=', $score)
            ->where('to_mark', '>=', $score)
            ->orderBy('weight')
            ->first();
    }
}
