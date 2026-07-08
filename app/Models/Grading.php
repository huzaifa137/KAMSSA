<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    use HasFactory;

    protected $table = 'grading';
    protected $primaryKey = 'ID';

    protected $fillable = [
        'Grade', 'From', 'To', 'Comment', 'Level', 'Weight', 'Type'
    ];

    public $timestamps = false;

    // Scope for marks grading
    public function scopeMarks($query, $level = 'A')
    {
        return $query->where('Type', 'Marks')
                     ->where('Level', $level)
                     ->orderBy('Weight');
    }

    // Scope for points grading (degree classification)
    public function scopePoints($query, $level = 'A')
    {
        return $query->where('Type', 'Points')
                     ->where('Level', $level)
                     ->orderBy('Weight');
    }

    // Get grade for a specific score
    public static function getGrade($score, $type = 'Marks', $level = 'A')
    {
        return self::where('Type', $type)
                   ->where('Level', $level)
                   ->where('From', '<=', $score)
                   ->where('To', '>=', $score)
                   ->first();
    }
}