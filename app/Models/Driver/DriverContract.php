<?php

namespace App\Models\Driver;

use App\Models\Company\CompanyHub;
use App\Models\RiskManager\RiskManagerSession;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class DriverContract extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = [];

    protected $filters = ['driver_document_1', 'vehicle_licence_plate',  'created_at', 'status'];

    public function created_at($query, $value)
    {
        return $query->whereDate('created_at', $value);
    }

    public function hubs()
    {
        
        return $this->belongsToMany(CompanyHub::class, 'driver_contract_hubs', 'driver_contract_id')->withPivot('approval_date', 'distance', 'company');
    }

    public function driverPartner()
    {
        return $this->belongsTo(DriverPartner::class);
    }

    public function session()
    {
        return $this->belongsTo(RiskManagerSession::class, 'risk_manager_session_id')->with('riskManager');
    }
}
