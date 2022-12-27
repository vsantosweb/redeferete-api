<?php

namespace App\Jobs;

use App\Models\Company\CompanyHub;
use App\Models\Driver\Driver;
use App\Models\PreRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class PreRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $tries = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public $data)
    {
        $this->data = (object) $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $avaiableCompanyHub = CompanyHub::checkDriverDistanceHubAvaiable($this->data->zipcode);

        $response = json_decode(Http::get('https://viacep.com.br/ws/' . $this->data->zipcode . '/json/')->body());

        $registerData = [
            'name'          => $this->data->name,
            'email'         => $this->data->email,
            'phone'         => $this->data->phone,
            'licence_plate' => strtoupper($this->data->licence_plate),
            'vehicle_type'  => $this->data->vehicle_type,
            'zipcode'       => $this->data->zipcode,
            'city'          => $response->localidade,
            'is_avaiable'   => $avaiableCompanyHub['avaiable'],
        ];

        if ($avaiableCompanyHub['avaiable']) {
            $registerData['company']  = $avaiableCompanyHub['hub']['company'];
            $registerData['hub']      = $avaiableCompanyHub['hub']['hub'];
            $registerData['code']     = $avaiableCompanyHub['hub']['code'];
            $registerData['distance'] = $avaiableCompanyHub['hub']['distance'];

            $data['driver_status_id'] = 5;
            $data['password']         = Hash::make(microtime());
            $data['name']             = $this->data->name;
            $data['email']            = $this->data->email;
            $data['phone']            = $this->data->phone;

            $newDriver = Driver::create($data);

            SendMailConfirmationJob::dispatch('ACCEPTED', $newDriver);
        } else {
            SendMailConfirmationJob::dispatch('REFUSED', $this->data);
        }

        PreRegistration::updateOrCreate($registerData);
    }
}
