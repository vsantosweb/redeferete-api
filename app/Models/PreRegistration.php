<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

class PreRegistration extends Model
{
    use HasFactory, FilterQueryString;

    protected $guarded = [];

    protected $filters = ['zipcode', 'hub', 'vehicle_type', 'created_at', 'is_avaiable', 'city'];

    public function created_at($query, $value)
    {
        return $query->whereDate('created_at', $value);
    }
}
