<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SchoolRegistrationSlot extends Model
{
    protected $table = 'school_registration_slots';
    protected $fillable = [
        'school_id',
        'admission_year',
        'slots_allocated',
        'slots_used',
        'registration_open',
        'notes',
        'allocated_by',
    ];
    protected $casts = ['registration_open' => 'boolean'];

    public function school()
    {
        return $this->belongsTo(House::class, 'school_id', 'ID');
    }

    public function slotsRemaining(): int
    {
        return max(0, $this->slots_allocated - $this->slots_used);
    }

    public function syncUsed(): void
    {
        $this->slots_used = StudentRegistration::where('school_id', $this->school_id)
            ->where('admission_year', $this->admission_year)
            ->count();
        $this->save();
    }
}
