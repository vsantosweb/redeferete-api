<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuepSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'token',
        'expire_at',
    ];
}
