<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateTracker extends Model
{
    protected $fillable = [
        'item_id',
        'item_category',
        'updated_by',
        'date_updated_on',
    ];

    protected $casts = [
        'date_updated_on' => 'datetime',
    ];
}
