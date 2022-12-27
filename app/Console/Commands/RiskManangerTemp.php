<?php

namespace App\Console\Commands;

use App\Models\Driver\DriverContract;
use App\Models\Driver\DriverPartner;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class RiskManangerTemp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'risk-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $ids = [307, 310];
        foreach ($ids as $id) {
            $dp      = DriverPartner::where('id', $id)->first();
            $partner = $dp->partner;
            $driver  = $dp->driver;
            $vehicle = $dp->vehicle;

            $driverPartnerContract = DriverContract::updateOrCreate(
                ['ref' => 'REDEFRE_' . strtoupper(Str::random(6))],
                [
                    'driver_partner_id'                 => $dp->id,
                    'external_id'                       => microtime(),
                    'status'                            => 'ACORDO',
                    'issue_date'                        => now(),
                    'expire_at'                         => now()->addYear(1),
                    'risk_manager_session_id'           => 1,
                    'requester_name'                    => $driver->name,
                    'requester_email'                   => $driver->email,
                    'requester_phone'                   => $driver->phone,
                    'requester_document'                => $driver->document_1,
                    'driver_name'                       => $partner->name,
                    'driver_email'                      => $partner->email,
                    'driver_phone'                      => $partner->phone,
                    'driver_document_1'                 => $partner->document_1,
                    'driver_gender'                     => $partner->gender,
                    'driver_birthday'                   => $partner->birthday,
                    'driver_address'                    => $partner->address->formatted_address,
                    'driver_zipcode'                    => $partner->address->zipcode,
                    'driver_licence_number'             => $partner->licence->document_number,
                    'driver_licence_security_code'      => $partner->licence->security_code,
                    'driver_licence_expire_at'          => $partner->licence->expire_at,
                    'driver_licence_first_licence_date' => $partner->licence->first_licence_date,
                    'driver_licence_uf'                 => $partner->licence->uf,
                    'driver_licence_mother_name'        => $partner->licence->mother_name,
                    'vehicle_brand'                     => $vehicle->brand,
                    'vehicle_model'                     => $vehicle->model,
                    'vehicle_version'                   => $vehicle->version,
                    'vehicle_licence_plate'             => $vehicle->licence_plate,
                    'vehicle_licence_number'            => $vehicle->licence_number,
                ]
            );
        }

        return 0;
    }
}
