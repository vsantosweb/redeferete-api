<?php

namespace App\Repository\Services\Eloquent\Driver;

use App\Models\Driver\DriverBank;
use App\Repository\Interfaces\Driver\IDriverBankRepository;
use App\Repository\Services\Eloquent\EloquentBaseRepository;

class EloquentDriverBankRepository extends EloquentBaseRepository implements IDriverBankRepository
{
    public function __construct(DriverBank $model)
    {
        $this->model = $model;
    }

    /**
     * Prepare the data to save to the base.
     * @param array $data
     * @param  int $driverId
     */
    public function prepare(array $data, $driverId): array
    {
        $data = [
            'driver_id'   => $driverId,
            'document'    => strtoupper($data['document']),
            'name'        => strtoupper($data['name']),
            'type'        => $data['type'],
            'bank_name'   => $data['bank_name'],
            'bank_agency' => $data['bank_agency'],
            'bank_number' => $data['bank_number'],
            'bank_digit'  => $data['bank_digit'],
        ];

        return $data;
    }
}
