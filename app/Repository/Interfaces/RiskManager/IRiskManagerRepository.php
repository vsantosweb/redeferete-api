<?php

namespace App\Repository\Interfaces\RiskManager;

interface IRiskManagerRepository
{
    public function checkDriver(object $vehicle, object $partner, $driver);
}
