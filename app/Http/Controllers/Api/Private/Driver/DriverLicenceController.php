<?php

namespace App\Http\Controllers\Api\Private\Driver;

use App\Http\Controllers\Controller;
use App\Repository\Interfaces\Driver\IDriverRepository;
use Illuminate\Http\Request;

class DriverLicenceController extends Controller
{
    protected IDriverRepository $driver;

    public function __construct(IDriverRepository $driverRepository)
    {
        $this->driver = $driverRepository;
    }

    public function changeLicenceStatus(Request $request, $driverId)
    {
        $driver = $this->driver->model()->find($driverId);

        $driver->licence->status = $request->status;

        $driver->licence->save();

        $driver->driverStatusCheck();

        return $this->outputJSON($driver);
    }
}
