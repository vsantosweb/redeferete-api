<?php

namespace App\Models\Driver;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_id',
        'document_id',
        'document_number',
        'file_path',
        'file_format',
        'file_sent',
        'status',
        'is_main',
        'metadata',
    ];

    protected $casts = ['metadata' => 'object'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
