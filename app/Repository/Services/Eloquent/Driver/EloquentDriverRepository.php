<?php

namespace App\Repository\Services\Eloquent\Driver;

use App\Models\Driver\Driver;
use App\Repository\Interfaces\Driver\IDriverRepository;
use App\Repository\Services\Eloquent\EloquentBaseRepository;

class EloquentDriverRepository extends EloquentBaseRepository implements IDriverRepository
{
    public $model;

    /**
     * Repository constructor.
     *
     * @param Driver $model
     */
    public function __construct(Driver $model)
    {
        $this->model = $model;
    }

    /**
     * Check Driver status.
     *
     * @return $this
     */
    public function driverStatusCheck(): Driver
    {
        $healthCheck = [$this->model->licence->status, $this->model->address->status];

        if (count(array_keys($healthCheck, 1)) == count($healthCheck)) {
            $this->model->driver_status_id = 1;
            $this->model->save();

            return $this;
        }

        $this->driver_status_id = 3;

        $this->model->save();

        return $this->model;
    }
}
