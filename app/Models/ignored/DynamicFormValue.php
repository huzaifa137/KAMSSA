<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicFormValue extends Model
{
    use HasFactory;

    protected $table = 'dynamic_form_values';

    protected $fillable = [
        'master_data_id',
        'field_name',
        'field_value',
        'field_type',
        'field_options',
    ];

    protected $casts = [
        'field_options' => 'array',
    ];


    // public function masterData()
    // {
    //     return $this->belongsTo(MasterData::class);
    // }
}
