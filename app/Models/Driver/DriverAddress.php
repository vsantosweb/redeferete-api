<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverAddress extends Model
{
    use HasFactory;

    protected $fillable = [

        'driver_id',
        'address_1',
        'address_2',
        'number',
        'complement',
        'zipcode',
        'city',
        'state',
        'billing_address',
        'document_file',
        'status',
        'formatted_address',
        'geolocation',
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
