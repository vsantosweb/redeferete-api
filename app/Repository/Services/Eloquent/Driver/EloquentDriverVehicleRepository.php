<?php

namespace App\Repository\Services\Eloquent\Driver;

use App\Models\Driver\Driver;
use App\Models\Vehicle\Vehicle;
use App\Repository\Interfaces\Driver\IDriverVehicleRepository;
use App\Repository\Services\Eloquent\EloquentBaseRepository;
use App\Repository\Services\Storage\StorageService;
use Illuminate\Support\Str;

class EloquentDriverVehicleRepository extends EloquentBaseRepository implements IDriverVehicleRepository
{
    public function __construct(Vehicle $model, StorageService $storage, Driver $driver)
    {
        $this->model   = $model;
        $this->storage = $storage;
        $this->driver  = $driver;
    }

    /**
     * Prepare the data to save to the base.
     */
    public function prepare(array $payload, int $driverId): array
    {
        $uuid = Str::uuid();

        $decodedFile = $this->storage->decodeFile($payload['document_file']);

        $fileInfo = $decodedFile->save($this->driver->find($driverId)->home_dir . DIRECTORY_SEPARATOR . 'vehicles' . DIRECTORY_SEPARATOR . $uuid, 'crlv');

        $payload['uuid']          = $uuid;
        $payload['driver_id']     = $driverId;
        $payload['document_url']  = $fileInfo['url'];
        $payload['document_path'] = $fileInfo['path'];
        $payload['status']        = 2;

        $payload = [
            'uuid'              => $uuid,
            'driver_id'         => $driverId,
            'vehicle_type_id'   => $payload['vehicle_type_id'],
            'driver_bank_id'    => $payload['driver_bank_id'],
            'brand'             => $payload['brand'],
            'model'             => $payload['model'],
            'uf'                => $payload['uf'],
            'licence_plate'     => strtoupper($payload['licence_plate']),
            'licence_number'    => $payload['licence_number'],
            'owner_document'    => $payload['owner_document'],
            'document_url'      => $fileInfo['url'],
            'document_path'     => $fileInfo['path'],
            'owner_name'        => ucfirst($payload['owner_name']),
            'owner_phone'       => $payload['owner_phone'] ?? null,
            'owner_birthday'    => $payload['owner_birthday'],
            'owner_mother_name' => ucfirst($payload['owner_mother_name']),
            'owner_rg'          => $payload['owner_rg'],
            'owner_rg_uf'       => $payload['owner_rg_uf'],
            'owner_rg_issue'    => $payload['owner_rg_issue'],
            'status'            => 2,
        ];

        return $payload;
    }
}
