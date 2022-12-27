<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class CaptureLead extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'licence_plate',
        'vehicle_type',
        'zipcode',
    ];

    protected static function booting()
    {
        static::creating(fn (CaptureLead $captureLead) => [
            $captureLead->name  = ucwords(strtolower($captureLead->name)),
            $captureLead->email = strtolower($captureLead->email),
            $captureLead->phone = str_replace(['(', ')', '-'], '', $captureLead->phone),
        ]);
    }
}
