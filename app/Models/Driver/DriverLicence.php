<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DriverLicence extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'driver_id',
        'driver_licence_category_id',
        'document_number',
        'document_file',
        'security_code',
        'expire_at',
        'uf',
        'first_licence_date',
        'mother_name',
        'status',
    ];

    protected static function booting()
    {
        static::creating(fn (DriverLicence $driverLicence) => [
            $driverLicence->uuid        = Str::uuid(),
            $driverLicence->mother_name = strtoupper($driverLicence->mother_name),
        ]);
    }

    public function category()
    {
        return $this->belongsTo(DriverLicenceCategory::class, 'driver_licence_category_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
