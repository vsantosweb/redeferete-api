<?php

namespace App\Models\Company;

use App\Models\Driver\DriverCompanyHub;
use App\Models\Driver\DriverContract;
use App\Models\SystemSetting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class CompanyHub extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function checkDriverDistanceHubAvaiable($driverAddress)
    {
        $resultAddresses = [];

        $maxDistanceAllowed = SystemSetting::first()->config->max_distance_between_driver_hub;

        self::with('company')->chunk(2, function ($chunk) use (&$resultAddresses, $driverAddress) {
            $geoLocations = $chunk->map(fn ($item) => $item->geolocation)->toArray();

            $response = Http::get(
                env('GOOGLE_MAPS_API_URI') .
                    '/distancematrix/json?destinations=' . implode('|', $geoLocations) . '&' .
                    'origins=' . $driverAddress . '&' .
                    'key=' . env('GOOGLE_MAPS_API_KEY')
            );

            $googleAdress = json_decode($response);

            $googleAdress->hubs = $chunk->toArray();

            $resultAddresses[] = $googleAdress;
        });

        $avaiableAddresses = [];

        // dd($resultAddresses);
        foreach ($resultAddresses as $key => $address) {
            $hubs = collect($address->rows[0]->elements)->map(function ($item, $index) use (&$address, $key) {
                if (!empty(array_filter($address->destination_addresses))) {
                    return [
                        'id'               => $address->hubs[$index]['id'],
                        'address'          => $address->destination_addresses[$index],
                        'original_address' => $address->destination_addresses[$index],
                        'distance'         => $item->distance->value,
                        'hub'              => $address->hubs[$index]['name'],
                        'company'          => $address->hubs[$index]['company']['name'],
                        'code'             => $address->hubs[$index]['code'],
                    ];
                }
            })->toArray();

            $avaiableAddresses = array_merge($hubs, $avaiableAddresses);
        }

        if (!empty(array_filter($avaiableAddresses))) {

            $allowedAddreses = collect($avaiableAddresses)->filter(fn ($address) => $maxDistanceAllowed >= $address['distance']);

            if (!$allowedAddreses->isEmpty()) {
                
                return [
                    'avaiable' => true,
                    'hubs'      => $allowedAddreses,
                ];
            }

            return [
                'avaiable' => false,
                'hubs'      => [],
            ];
        }

        return false;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function drivers()
    {
        return $this->hasMany(DriverCompanyHub::class);
    }

    public function contracts()
    {
        return $this->belongsToMany(DriverContract::class, 'driver_contract_hubs');
    }
}
