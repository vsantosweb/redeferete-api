<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserType extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
    ];

    protected static function booted()
    {
        static::creating(function (self $userType) {
            $userType->slug = Str::slug($userType->name);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
