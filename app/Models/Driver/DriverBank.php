<?php

namespace App\Models\Driver;

use App\Models\Vehicle\Vehicle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverBank extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'driver_id',
        'document',
        'name',
        'status',
        'type',
        'code',
        'bank_name',
        'bank_agency',
        'bank_number',
        'bank_digit',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
