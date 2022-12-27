<?php

namespace App\Repository\Interfaces\Driver;

use App\Repository\Interfaces\IBaseRepository;

interface IDriverVehicleRepository extends IBaseRepository
{
    public function prepare(array $data, int $driverId);
}
