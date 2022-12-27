<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverLicenceCategoryResource;
use App\Http\Resources\Vehicle\VehicleTypeResource;
use App\Models\Company\CompanyHub;
use App\Models\Driver\DriverLicenceCategory;
use App\Models\Vehicle\Vehicle;
use App\Models\Vehicle\VehicleType;

class PublicController extends Controller
{
    public function getVehicleTypes()
    {
        return $this->outputJSON(VehicleTypeResource::collection(VehicleType::all()));
    }

    public function getLicenceCategories()
    {
        return $this->outputJSON(DriverLicenceCategoryResource::collection(DriverLicenceCategory::all()));
    }

    public function checkVehicleExists($licencePlate)
    {
        $findVehicle = Vehicle::where('licence_plate', $licencePlate)->first();

        if (!is_null($findVehicle)) {
            return $this->outputJSON([], 'Veículo indisponível.', false, 200);
        }

        return $this->outputJSON([], null, true, 200);
    }

    public function checkDriverAvaiableHub($address)
    {
        return CompanyHub::checkDriverDistanceHubAvaiable($address);
    }
}
