<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SchoolSlotHistory extends Model
{
    protected $table = 'school_slot_history';
    protected $fillable = [
        'school_id','admission_year','slots_added','total_after','reason','added_by',
    ];
}
