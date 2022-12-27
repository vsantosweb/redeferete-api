<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DriverStatus extends Model
{
    use HasFactory;

    protected static function booting()
    {
        static::creating(fn (DriverStatus $driverStatus) => [
            $driverStatus->name = $driverStatus->name,
            $driverStatus->slug = Str::slug($driverStatus->name),
        ]);

        static::updating(fn (DriverStatus $driverStatus) => [
            $driverStatus->name = $driverStatus->name,
            $driverStatus->slug = Str::slug($driverStatus->name),
        ]);
    }

    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
}
