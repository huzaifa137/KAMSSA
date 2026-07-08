<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'senior_id',
        'subject_id',
        'topic_name',
        'Competency',
        'topic_description',
        'topic_date_added',
        'topic_added_by',
    ];

    public function senior()
    {
        return $this->belongsTo(MasterData::class, 'senior_id', 'md_id');
    }

    public function subject()
    {
        return $this->belongsTo(MasterData::class, 'subject_id', 'md_id');
    }

}
