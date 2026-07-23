<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarksEntrantAssignment extends Model
{
    protected $table = 'marks_entrant_assignments';

    protected $fillable = [
        'user_id',
        'subject_id',
        'paper_number',
        'category',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The MasterData row (md_id) this assignment's subject_id points to.
     */
    public function subject()
    {
        return $this->belongsTo(MasterData::class, 'subject_id', 'md_id');
    }
}