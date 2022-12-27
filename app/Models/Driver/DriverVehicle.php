<?php

namespace App\Models\Driver;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverVehicle extends Vehicle
{
    use HasFactory;

    protected $table = 'vehicles';

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
