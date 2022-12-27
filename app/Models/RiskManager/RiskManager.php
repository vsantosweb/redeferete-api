<?php

namespace App\Models\RiskManager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskManager extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function sessions()
    {
        return $this->hasMany(RiskManagerSession::class);
    }
}
