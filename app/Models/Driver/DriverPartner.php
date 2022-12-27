<?php

namespace App\Models\Driver;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DriverPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'driver_id',
        'partner_id',
        'vehicle_id',
        'name',
        'email',
        'status',
        'accepted_at',
    ];

    /**
     * Default dataset.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(fn (DriverPartner $driverPartner) => [
            $driverPartner->uuid = Str::uuid(),
        ]);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function partner()
    {
        return $this->belongsTo(Driver::class, 'partner_id');
    }

    public function contracts()
    {
        return $this->hasMany(DriverContract::class, 'driver_partner_id');
    }
}
