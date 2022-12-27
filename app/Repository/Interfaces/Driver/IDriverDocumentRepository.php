<?php

namespace App\Repository\Interfaces\Driver;

interface IDriverDocumentRepository
{
}

interface IDriverLicenceRepository
{
    /**
     * @var $father_name;
     * @var $mother_name;
     * @var $type;
     * @var $uf;
     * @var $document_number;
     * @var $security_code;
     * @var $expire_at;
     */
    public function makeLicence(array $payload, int $driverId);
}

interface IDriverAddressRepository
{
    /**
     * @var $driver_id
     * @var $address_1
     * @var $address_2
     * @var $number
     * @var $complement
     * @var $zipcode
     * @var $city
     * @var $state
     * @var $billing_address
     */
    public function makeAddress(array $payload, int $driverId);
}
