<?php

namespace App\Console\Commands;

use App\Models\Company\CompanyHub;
use App\Models\Driver\DriverContract;
use App\Models\Driver\DriverContractHub;
use App\Services\Guep\GuepService;
use Illuminate\Console\Command;

class GuepValidationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guep';

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
     * @var GuepService
     */
    public function handle()
    {
        // $guep = new GuepService();
        $guep = '';

        DriverContract::where('status', 'ACORDO')->chunk(1024, function ($chunk) use ($guep) {
            foreach ($chunk->all() as $contract) {
                // $contractReference = $guep->getReference($contract->ref);
                // $status = $contractReference->data->registros[0]->laudo_conjunto_label;

                $status = 'ACORDO';

                echo 'Checking...' . $contract->ref . '...' . $status . "\n";

                if ($status !== 'PENDENTE') {
                    $contract->status = $status;
                    $contract->save();

                    if ($status === 'ACORDO') {
                        $contract->driverPartner->status = 1;
                        $contract->driverPartner->save();

                        $company = CompanyHub::find(mt_rand(52, 120));

                        // DriverContractHub::firstOrCreate([
                        //     'driver_contract_id' => $contract->id,
                        //     'company_hub_id'     => $company->id,
                        //     'approval_date'      => now(),
                        //     'distance'           => mt_rand(60000, 200000),
                        //     'company'            => $company->company->name,
                        // ]);

                        $allowedHubs = CompanyHub::checkDriverDistanceHubAvaiable($contract->driverPartner->partner->address->zipcode);


                        if ($allowedHubs['avaiable']) {

                            foreach ($allowedHubs['hubs'] as $hub) {
                                DriverContractHub::firstOrCreate([
                                    'driver_contract_id' => $contract->id,
                                    'company_hub_id'     => $hub['id'],
                                    'approval_date' => now(),
                                    'distance'  => $hub['distance'],
                                    'company'  => $hub['company']
                                ]);
                            }
                        }
                    }
                }
            }
        });

        echo 'Finished ' . now() . "\n";

        return 0;
    }
}
