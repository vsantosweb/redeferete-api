<?php

namespace Database\Seeders;

use App\Models\Company\CompanyHub;
use App\Models\Driver\DriverContract;
use App\Models\Driver\DriverContractHub;
use App\Models\Driver\DriverPartner;
use App\Models\RiskMananger\RiskManager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DriverContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (DriverPartner::all() as $dp) {
            $driverContract = DriverContract::updateOrCreate(
                ['ref' => 'REDEFRE_' . strtoupper(Str::random(6))],
                [
                    'driver_partner_id'                 => $dp->id,
                    'external_id'                       => microtime(),
                    'status'                            => 'ACORDO',
                    'issue_date'                        => now(),
                    'expire_at'                         => now()->addYear(1),
                    'risk_manager_id'                   => RiskManager::where('default', true)->first()->id,
                    'requester_name'                    => $dp->driver->name,
                    'requester_email'                   => $dp->driver->email,
                    'requester_phone'                   => $dp->driver->phone,
                    'requester_document'                => $dp->driver->document_1,
                    'driver_name'                       => $dp->partner->name,
                    'driver_email'                      => $dp->partner->email,
                    'driver_phone'                      => $dp->partner->phone,
                    'driver_document_1'                 => $dp->partner->document_1,
                    'driver_gender'                     => $dp->partner->gender,
                    'driver_birthday'                   => $dp->partner->birthday,
                    'driver_address'                    => $dp->partner->address->formatted_address,
                    'driver_zipcode'                    => $dp->partner->address->zipcode,
                    'driver_licence_number'             => $dp->partner->licence->document_number,
                    'driver_licence_security_code'      => $dp->partner->licence->security_code,
                    'driver_licence_expire_at'          => $dp->partner->licence->expire_at,
                    'driver_licence_first_licence_date' => $dp->partner->licence->first_licence_date,
                    'driver_licence_uf'                 => $dp->partner->licence->uf,
                    'driver_licence_mother_name'        => $dp->partner->licence->mother_name,
                    'vehicle_brand'                     => $dp->vehicle->brand,
                    'vehicle_model'                     => $dp->vehicle->model,
                    'vehicle_version'                   => $dp->vehicle->version,
                    'vehicle_licence_plate'             => $dp->vehicle->licence_plate,
                    'vehicle_licence_number'            => $dp->vehicle->licence_number,
                ]
            );

            $company = CompanyHub::all()->random();

            DriverContractHub::firstOrCreate([
                'driver_contract_id' => $driverContract->id,
                'company_hub_id'     => $company->id,
                'approval_date'      => now(),
                'distance'           => mt_rand(60000, 200000),
                'company'            => $company->company->name,
            ]);
        }
    }
}
