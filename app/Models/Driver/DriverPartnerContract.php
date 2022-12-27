<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DriverPartnerContract extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function driverPartner()
    {
        return $this->belongsTo(DriverPartner::class);
    }
}
