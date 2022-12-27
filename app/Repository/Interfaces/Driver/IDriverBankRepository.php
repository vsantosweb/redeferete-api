<?php

namespace App\Repository\Interfaces\Driver;

use App\Repository\Interfaces\IBaseRepository;

interface IDriverBankRepository extends IBaseRepository
{
    public function prepare(array $data, $driverId);
}
