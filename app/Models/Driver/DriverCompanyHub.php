<?php

namespace App\Models\Driver;

use App\Models\Company\CompanyHub;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverCompanyHub extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function hub()
    {
        return $this->belongsTo(CompanyHub::class, 'company_hub_id');
    }
}
