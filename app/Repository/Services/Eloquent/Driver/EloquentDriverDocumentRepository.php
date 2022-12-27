<?php

namespace App\Repository\Services\Eloquent\Driver;

use App\Models\Driver\DriverAddress;
use App\Models\Driver\DriverLicence;
use App\Repository\Interfaces\Driver\IDriverDocumentRepository;
use App\Repository\Services\Eloquent\EloquentBaseRepository;
use App\Repository\Services\Storage\StorageService;
use Illuminate\Support\Facades\Http;

class EloquentDriverDocumentRepository extends EloquentBaseRepository implements IDriverDocumentRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Repository constructor.
     *
     * @param StorageService $storage
     */
    public function __construct(StorageService $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Create licence.
     */
    public function makeLicence(array $payload, int $driverId): void
    {
        $decodedFile = $this->storage->decodeFile($payload['document_file']);

        /** @var DriverLicence $driverLicence */
        $driverLicence = DriverLicence::updateOrCreate(
            ['driver_id' => $driverId],
            [
                'mother_name'                => $payload['mother_name'],
                'driver_licence_category_id' => $payload['driver_licence_category_id'],
                'document_number'            => $payload['document_number'],
                'security_code'              => $payload['security_code'],
                'uf'                         => $payload['uf'],
                'expire_at'                  => $payload['expire_at'],
                'first_licence_date'         => $payload['first_licence_date'],
            ]
        );

        $fileInfo = $decodedFile->save($driverLicence->driver->home_dir . DIRECTORY_SEPARATOR . 'documents', 'cnh');

        $driverLicence->document_file = $fileInfo['url'];
        $driverLicence->save();
        $driverLicence->driver->save();
    }

    /**
     * Create address.
     */
    public function makeAddress(array $payload, int $driverId): void
    {
        $decodedFile = $this->storage->decodeFile($payload['document_file']);

        $response = Http::get(
            env('GOOGLE_MAPS_API_URI') .
                '/geocode/json?address=' . implode(',', [$payload['address_1'], $payload['number'] . '-' . $payload['zipcode']]) . '&' .
                'key=' . env('GOOGLE_MAPS_API_KEY')
        );

        $googleAdress = json_decode($response);

        /** @var DriverAddress $driverAddress */
        $driverAddress = DriverAddress::updateOrCreate(
            [
                'driver_id' => $driverId,
            ],
            [
                'address_1'         => $payload['address_1'],
                'address_2'         => $payload['address_2'],
                'number'            => $payload['number'],
                'complement'        => $payload['complement'],
                'zipcode'           => $payload['zipcode'],
                'city'              => $payload['city'],
                'state'             => $payload['state'],
                'formatted_address' => $googleAdress->results[0]->formatted_address,
                'geolocation'       => $googleAdress->results[0]->geometry->location->lat . ',' . $googleAdress->results[0]->geometry->location->lng,
            ]
        );

        $fileInfo = $decodedFile->save($driverAddress->driver->home_dir . DIRECTORY_SEPARATOR . 'documents', 'comprovante_residencial');

        $driverAddress->document_file = $fileInfo['url'];
        $driverAddress->save();
        $driverAddress->driver->save();
    }
}
