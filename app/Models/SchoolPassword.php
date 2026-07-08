<?php
// app/Models/SchoolPassword.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolPassword extends Model
{
    protected $table = 'school_passwords';
    
    protected $fillable = [
        'school_id',
        'password_plain',
        'password_hashed'
    ];
    
    // Relationship with House (School)
    public function school()
    {
        return $this->belongsTo(House::class, 'school_id', 'Number');
    }
}