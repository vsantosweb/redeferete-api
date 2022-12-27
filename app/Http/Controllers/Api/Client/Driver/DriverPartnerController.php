<?php

namespace App\Http\Controllers\Api\Client\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverPartnerResource;
use App\Models\Driver\Driver;
use App\Repository\Interfaces\Driver\IDriverRepository;
use App\Repository\Services\RiskMananger\RiskManangerService;
use Illuminate\Http\Request;

class DriverPartnerController extends Controller
{
    /**
     * RiskManangerService repository implementation.
     * @var RiskManangerService
     */
    protected $riskManager;

    /**
     * IDriverRepository repository implementation.
     * @var IDriverRepository
     */
    protected $driver;

    /**
     * Create a new controller instance.
     *
     * @param  IDriverRepository  $driverRepository
     * @return void
     */
    public function __construct(IDriverRepository $driver, RiskManangerService $riskManger)
    {
        $this->driver      = $driver;
        $this->riskManager = $riskManger;
    }

    public function partnerVehicles()
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        $partners = $driver->partnerVehicles()->where('driver_id', '!=', $driver->id)->get();

        return $this->outputJSON(DriverPartnerResource::collection($partners), '', true, 200);
    }

    public function invitePartner(Request $request)
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        $driverToInvite = $this->driver->model()
            ->where('email', $request->email)
            ->where('email', '!=', $driver->email)->first();

        if (is_null($driverToInvite)) {
            return $this->outputJSON([], 'O motorista precisa possuir um cadastro Redefrete e ser autêntico, para ser convidado.', false, 200);
        }

        $invited = $driver->partners()
            ->where('vehicle_id', $request->vehicle_id)
            ->where('partner_id', $driverToInvite->id)->first();

        if (!is_null($invited)) {
            return $this->outputJSON([], 'Motorista já está vinculado ao veículo.', false, 200);
        }

        $newInvite = $driver->partners()->firstOrCreate([
            'partner_id' => $driverToInvite->id,
            'name'       => $driverToInvite->name,
            'email'      => $driverToInvite->email,
            'vehicle_id' => $request->vehicle_id,
            'status'     => 2, //pending
        ]);

        return $this->outputJSON($newInvite, 'Success', true, 201);
    }

    public function inviteAction(Request $request, $uuid)
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        $partnerUpdate = $driver->partnerVehicles()->where('uuid', $uuid)->firstOrFail();

        if (is_null($partnerUpdate)) {
            throw new \Exception('Error Processing Request', 1);
        }

        $riskMananger = $this->riskManager::getDefaultRiskMananger();

        switch ($request->action) {
            case 'accept':

                $riskMananger->checkDriver($partnerUpdate, $partnerUpdate->vehicle, $partnerUpdate->driver);

                /* Sends driver and vehicle data for analysis */

                $partnerUpdate->update(['status' => 3, 'accepted_at' => now()]);

                return $this->outputJSON($partnerUpdate, 'Success', true, 200);

                break;

            case 'reject':

                $partnerUpdate->status = 0;
                $partnerUpdate->save();

                return $this->outputJSON($partnerUpdate, 'Success', true, 200);

            case 'exclude':

                $partnerUpdate->delete();

                return $this->outputJSON($partnerUpdate, 'Success', true, 200);

            default:

                throw new \Exception('Error Processing Request', 1);
                break;
        }

        return $request->all();
    }
}
