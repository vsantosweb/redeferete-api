<?php

namespace App\Models\RiskManager;

use App\Models\Driver\DriverContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskManagerSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_manager_id',
        'type',
        'token',
        'expire_at',
    ];

    public function riskManager()
    {
        return $this->belongsTo(RiskManager::class, 'risk_manager_id');
    }

    public function contracts()
    {
        return $this->hasMany(DriverContract::class);
    }
}
