<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    protected $table = 'months';
    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'Month',
    ];
}
