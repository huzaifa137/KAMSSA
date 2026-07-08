<?php
namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RegistrationPeriod extends Model
{
    protected $table = 'registration_periods';
    protected $fillable = ['name','admission_year','opens_at','closes_at','is_active','created_by'];
    protected $casts = ['opens_at'=>'datetime','closes_at'=>'datetime','is_active'=>'boolean'];

    public static function active(): ?self {
        return self::where('is_active', true)->first();
    }

    public static function globallyOpen(): bool {
        $period = self::active();
        if (!$period) return false;
        $now = Carbon::now();
        if ($period->opens_at && $now->lt($period->opens_at)) return false;
        if ($period->closes_at && $now->gt($period->closes_at)) return false;
        return true;
    }
}