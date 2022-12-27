<?php

namespace App\Models\Vehicle;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VehicleType extends Model
{
    use HasFactory;

    public static function booting()
    {
        static::creating(fn (VehicleType $vehicleType) => [
            $vehicleType->uuid = Str::uuid(),
        ]);
    }
}
