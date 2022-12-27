<?php

namespace App\Providers;

use App\Repository\Interfaces\Driver\IDriverBankRepository;
use App\Repository\Interfaces\Driver\IDriverDocumentRepository;
use App\Repository\Interfaces\Driver\IDriverRepository;
use App\Repository\Interfaces\Driver\IDriverVehicleRepository;
use App\Repository\Interfaces\User\IUserRepository;
use App\Repository\Services\Eloquent\Driver\EloquentDriverBankRepository;
use App\Repository\Services\Eloquent\Driver\EloquentDriverDocumentRepository;
use App\Repository\Services\Eloquent\Driver\EloquentDriverRepository;
use App\Repository\Services\Eloquent\Driver\EloquentDriverVehicleRepository;
use App\Repository\Services\Eloquent\User\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(IDriverDocumentRepository::class, EloquentDriverDocumentRepository::class);
        app()->bind(IDriverRepository::class, EloquentDriverRepository::class);
        app()->bind(IDriverBankRepository::class, EloquentDriverBankRepository::class);
        app()->bind(IDriverVehicleRepository::class, EloquentDriverVehicleRepository::class);

        app()->bind(IUserRepository::class, EloquentUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
