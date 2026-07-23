<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Combination extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'status',
    ];

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(
            MasterData::class,
            'combination_subjects',
            'combination_id',
            'subject_id'
        );
    }

    public function studentCombinations(): HasMany
    {
        return $this->hasMany(StudentCombination::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}