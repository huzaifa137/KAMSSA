<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolRecognitionCertificate extends Model
{
    protected $table = 'school_recognition_certificates';

    protected $fillable = [
        'house_number',
        'certificate_number',
        'issued_date',
        'issued_by',
        'status',
        'notes',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    /**
     * The school (house) this certificate belongs to.
     */
    public function house()
    {
        return $this->belongsTo(House::class, 'house_number', 'Number');
    }

    /**
     * Check if this certificate is currently active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}