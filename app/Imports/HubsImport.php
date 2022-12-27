<?php

namespace App\Imports;

use App\Models\Company\Company;
use App\Models\Company\CompanyHub;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;

class HubsImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $response = Http::get(
                env('GOOGLE_MAPS_API_URI') .
                    '/geocode/json?address=' . $row[3] . '&' .
                    'key=' . env('GOOGLE_MAPS_API_KEY')
            );

            $googleAdress = json_decode($response);

            echo json_encode($googleAdress) . "\n";

            if (isset($googleAdress->results[0])) {
                $teste = CompanyHub::firstOrCreate([
                    'company_id'  => Company::where('name', $row[2])->first()->id,
                    'code'        => trim($row[0]),
                    'name'        => trim($row[1]),
                    'geolocation' => $googleAdress->results[0]->geometry->location->lat . ',' . $googleAdress->results[0]->geometry->location->lng,
                    'address'     => $googleAdress->results[0]->formatted_address,
                ]);
            }
        }
    }
}
