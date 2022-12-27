<?php

namespace App\Http\Controllers\Api\Client\Driver;

use App\Http\Controllers\Controller;
use App\Http\Resources\Driver\DriverGuestInviteResource;
use App\Models\Driver\Driver;
use App\Repository\Interfaces\Driver\IDriverRepository;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected IDriverRepository $driver;

    public function __construct(IDriverRepository $driverRepository)
    {
        $this->driver = $driverRepository;
        $this->teste  = auth()->user();
    }

    public function liveSearch(Request $request)
    {
        $results = $this->driver
            ->model()
            ->where('email', 'LIKE', '%' . $request->email . '%')
            ->take(10)
            ->get();

        return $this->outputJSON($results, '', true, 200);
    }

    public function getInvites()
    {
        /** @var Driver $driver */
        $driver = auth()->user();

        $invites = $driver->invites()->with(['vehicle', 'driver'])->get();

        return $this->outputJSON(DriverGuestInviteResource::collection($invites), '', true, 200);
    }

    public function partners()
    {
    }
}
