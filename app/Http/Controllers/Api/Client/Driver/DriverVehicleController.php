<?php

namespace App\Http\Controllers\Api\Client\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver\Driver;
use App\Models\Driver\DriverPartner;
use App\Repository\Interfaces\Driver\IDriverVehicleRepository;
use App\Repository\Services\RiskMananger\RiskManangerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DriverVehicleController extends Controller
{
    protected IDriverVehicleRepository $vehicle;

    public function __construct(IDriverVehicleRepository $vehicle, RiskManangerService $riskManger)
    {
        $this->riskManager = $riskManger;
        $this->vehicle     = $vehicle;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->outputJSON(auth()->user()->vehicles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!is_null($this->vehicle->model()->where('licence_plate', $request->licence_plate)->first())) {
            return $this->outputJSON([], 'Veículo já cadastrado no sistema.', false, 422);
        }

        $riskMananger = $this->riskManager::getDefaultRiskMananger();

        // try {

        $newVehicle = $this->vehicle->model()->updateOrCreate($this->vehicle->prepare($request->all(), auth()->user()->id));

        $partner = DriverPartner::updateOrcreate([
            'driver_id'   => auth()->user()->id,
            'partner_id'  => auth()->user()->id,
            'vehicle_id'  => $newVehicle->id,
            'name'        => auth()->user()->name,
            'email'       => auth()->user()->email,
            'accepted_at' => now(),
        ]);

        $riskMananger->checkDriver($partner, $partner->vehicle, auth()->user());

        return $this->outputJSON($newVehicle, '', true, 201);
        // } catch (\Throwable $th) {
        //     return $this->outputJSON([], $th->getMessage(), false, 422);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($licencePlate)
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        return $this->outputJSON($driver->vehicles()->with(['partners' => function ($query) use ($driver) {
            $query->where('partner_id', '!=', $driver->id);
        }])->where('licence_plate', $licencePlate)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** @var Driver $driver */
        $driver = auth()->user();
        Storage::disk('public')->deleteDirectory($driver->vehicles()->find($id)->document_path);

        return $this->outputJSON($driver->vehicles()->find($id)->delete());
    }
}
