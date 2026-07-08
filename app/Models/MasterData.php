<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterData extends Model
{
    use HasFactory;

    protected $table = 'master_datas';

    protected $primaryKey = 'md_id';
    public $incrementing = true;
    protected $keyType = 'integer';

    public $timestamps = false; 

    protected $fillable = [
        'md_master_code_id',
        'md_code',
        'md_name',
        'md_description',
        'md_date_added',
        'md_added_by',
        'md_misc1',
        'md_misc2',
        'md_misc3',
        'md_misc4',
    ];


    // public function dynamicFormValues()
    // {
    //     return $this->hasMany(DynamicFormValue::class, 'master_data_id', 'md_id');
    // }
}
