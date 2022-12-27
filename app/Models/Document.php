<?php

namespace App\Models;

use App\Models\Driver\DriverDocument;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function driverDocuments()
    {
        return $this->hasMany(DriverDocument::class);
    }
}
