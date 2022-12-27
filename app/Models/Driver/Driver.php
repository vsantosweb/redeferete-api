<?php

namespace App\Models\Driver;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Mehradsadeghi\FilterQueryString\FilterQueryString;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Driver extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes, FilterQueryString;

    protected $filters = ['driver_document_1', 'vehicle_licence_plate',  'created_at', 'driver_status_id'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'phone',
        'mother_name',
        'gender',
        'rg',
        'birthday',
        'rg_uf',
        'rg_issue',
        'type',
        'document_1',
        'status',
        'notify',
        'newsletter',
        'email_verified_at',
        'last_activity',
        'home_dir',
        'first_time',
        'driver_status_id',
        'register_complete',
        'accepted_terms',
        'user_agent',
        'ip',
    ];

    /**
     * Default dataset.
     *
     * @return void
     */
    protected static function booting()
    {
        static::creating(fn (Driver $driver) => [
            $driver->uuid        = Str::uuid(),
            $driver->name        = ucwords(strtolower($driver->name)),
            $driver->email       = strtolower($driver->email),
            $driver->phone       = str_replace(['(', ')', '-'], '', $driver->phone),
            $driver->home_dir    = 'drivers/' . $driver->uuid,
            $driver->type        = strlen($driver->document_1) > 11 ? 'PJ' : 'PF',
            $driver->mother_name = ucwords(strtolower($driver->mother_name)),
        ]);

        static::updating(fn (Driver $driver) => [
            $driver->name        = ucwords(strtolower($driver->name)),
            $driver->email       = strtolower($driver->email),
            $driver->phone       = str_replace(['(', ')', '-'], '', $driver->phone),
            $driver->type        = strlen($driver->document_1) > 11 ? 'PJ' : 'PF',
            $driver->mother_name = ucwords(strtolower($driver->mother_name)),

        ]);
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function created_at($query, $value)
    {
        return $query->whereDate('created_at', $value);
    }

    public function status()
    {
        return $this->belongsTo(DriverStatus::class, 'driver_status_id');
    }

    /**
     * Check Driver status.
     *
     * @return $this
     */
    public function driverStatusCheck(): self
    {
        $healthCheck = [$this->licence->status, $this->address->status];

        if (count(array_keys($healthCheck, 1)) == count($healthCheck)) {
            $this->driver_status_id = 1;
            $this->save();

            return $this;
        }

        $this->driver_status_id = 3;

        $this->save();

        return $this;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function licence()
    {
        return $this->hasOne(DriverLicence::class);
    }

    public function address()
    {
        return $this->hasOne(DriverAddress::class);
    }

    public function vehicles()
    {
        return $this->hasMany(DriverVehicle::class);
    }

    public function documents()
    {
        return $this->hasMany(DriverDocument::class);
    }

    public function banks()
    {
        return $this->hasMany(DriverBank::class);
    }

    public function partners()
    {
        return $this->hasMany(DriverPartner::class, 'driver_id');
    }

    public function partnerVehicles()
    {
        return $this->hasMany(DriverPartner::class, 'partner_id');
    }

    public function hub()
    {
        return $this->hasOne(DriverCompanyHub::class, 'driver_id');
    }
}
