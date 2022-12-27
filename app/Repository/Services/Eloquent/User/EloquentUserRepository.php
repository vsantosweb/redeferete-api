<?php

namespace App\Repository\Services\Eloquent\User;

use App\Models\User\User;
use App\Repository\Interfaces\User\IUserRepository;
use App\Repository\Services\Eloquent\EloquentBaseRepository;

class EloquentUserRepository extends EloquentBaseRepository implements IUserRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }
}
