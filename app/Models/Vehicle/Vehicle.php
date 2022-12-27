<?php

namespace App\Models\Vehicle;

use App\Models\Driver\DriverBank;
use App\Models\Driver\DriverPartner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'uuid',
    //     'driver_id',
    //     'vehicle_type_id',
    //     'driver_bank_id',
    //     'status',
    //     'brand',
    //     'model',
    //     'version',
    //     'uf',
    //     'manufacture_date',
    //     'licence_plate',
    //     'licence_number',
    //     'owner_document',
    //     'owner_type',
    //     'antt',
    //     'owner_name',
    //     'owner_phone',
    //     'document_url',
    //     'document_path',
    // ];

    protected $guarded = [];

    protected static function booting()
    {
        static::creating(fn (Vehicle $vehicle) => [
            $vehicle->owner_type    = strlen($vehicle->owner_document) > 11 ? 'PJ' : 'PF',
            $vehicle->licence_plate = strtoupper($vehicle->licence_plate),
            $vehicle->status        = 2,
        ]);

        static::updating(fn (Vehicle $vehicle) => [
            $vehicle->owner_type    = strlen($vehicle->owner_document) > 11 ? 'PJ' : 'PF',
            $vehicle->licence_plate = strtoupper($vehicle->licence_plate),
        ]);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function partners()
    {
        return $this->hasMany(DriverPartner::class, 'vehicle_id')->with(['partner' => function ($query) {
            $query->select('id', 'name', 'email');
        }]);
    }

    public function bankAccount()
    {
        return $this->belongsTo(DriverBank::class);
    }

    public function type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_type_id');
    }
}
