<?php

namespace App\Repository\Services\RiskMananger\Guep;

use App\Models\Driver\DriverContract;
use App\Repository\Interfaces\RiskManager\IRiskManagerRepository;
use Illuminate\Support\Facades\Http;

class GuepService extends REST implements IRiskManagerRepository
{
    const SERVICE_NAME = 'GUEP';

    public function __construct()
    {
        parent::__construct();
    }

    public function checkDriver(object $partner, object $vehicle, $driver)
    {
        $partnerId = $partner->id;

        $driverPatner = $partner->partner;

        $data = $this->setData($driverPatner, $vehicle);

        /** @var Http $response */
        $responseSearch = json_decode($this->call('post', 'pesquisa/agregado', $data)->body());

        $reference = $responseSearch->message === 'Sucesso' ? $responseSearch->referencia : $partner->contracts->last()->ref
            ?? throw new \Exception('Error Processing Request: ' . $responseSearch->message, 1);

        $response = $this->getReference($reference);

        $contract = $response->data->registros[0];

        $driverPartnerContract = DriverContract::updateOrCreate(
            ['ref' => $contract->referencia],
            [
                'driver_partner_id'                 => $partnerId,
                'external_id'                       => $contract->id,
                'status'                            => $contract->laudo_conjunto_label,
                'issue_date'                        => $contract->data_registro,
                'expire_at'                         => now()->addYear(1),
                'risk_manager_session_id'           => $this->session->id,
                'requester_name'                    => $driver->name,
                'requester_email'                   => $driver->email,
                'requester_phone'                   => $driver->phone,
                'requester_document'                => $driver->document_1,
                'driver_name'                       => $driverPatner->name,
                'driver_email'                      => $driverPatner->email,
                'driver_phone'                      => $driverPatner->phone,
                'driver_document_1'                 => $driverPatner->document_1,
                'driver_gender'                     => $driverPatner->gender,
                'driver_birthday'                   => $driverPatner->birthday,
                'driver_address'                    => $driverPatner->address->formatted_address,
                'driver_zipcode'                    => $driverPatner->address->zipcode,
                'driver_licence_number'             => $driverPatner->licence->document_number,
                'driver_licence_security_code'      => $driverPatner->licence->security_code,
                'driver_licence_expire_at'          => $driverPatner->licence->expire_at,
                'driver_licence_first_licence_date' => $driverPatner->licence->first_licence_date,
                'driver_licence_uf'                 => $driverPatner->licence->uf,
                'driver_licence_mother_name'        => $driverPatner->licence->mother_name,
                'vehicle_brand'                     => $vehicle->brand,
                'vehicle_model'                     => $vehicle->model,
                'vehicle_version'                   => $vehicle->version,
                'vehicle_licence_plate'             => $vehicle->licence_plate,
                'vehicle_licence_number'            => $vehicle->licence_number,
            ]
        );

        $driverPatner->driver_status_id = $driverPartnerContract->status === 'ACORDO' ? 1 : 3;

        $driverPatner->save();
    }

    public function getReference(string $reference)
    {
        return json_decode($this->call('get', 'relatorio/:referencia&referencia=' . $reference)->body());
    }

    private function setData(object $partner, object $vehicle)
    {
        return [
            'desbloqueiaPesquisa2Horas' => true,
            'principal'                 => [
                'id_modalidade' => '1',
                'documento'     => $partner->document_1,
                'data_nasc'     => $partner->birthday,
                'mae'           => $partner->mother_name,
                'nome'          => $partner->name,
                'pai'           => 'Não Informado',
                'rg'            => $partner->rg,
                'rg_uf'         => $partner->rg_uf,
                'rg_emissao'    => $partner->rg_issue,
                'cnh'           => $partner->licence->document_number,
                'cnh_uf'        => $partner->licence->uf,
                'cnh_cat'       => $partner->licence->category->name,
                'cnh_first'     => $partner->licence->first_licence_date,
                'cnh_validate'  => $partner->licence->expire_at,
                'cnh_security'  => $partner->licence->security_code,
                'telefone'      => $partner->phone,
                'email'         => $partner->email,
            ],
            'veiculos' => [
                [
                    'placa'     => $vehicle->licence_plate,
                    'tipo'      => $vehicle->owner_type,
                    'documento' => $vehicle->owner_document,
                    'nome'      => $vehicle->owner_name,
                    'renavam'   => $vehicle->licence_number,
                    'uf'        => $vehicle->uf,
                ],
            ],
            'proprietarios' => [
                [
                    'tipo'          => $vehicle->owner_type,
                    'id_modalidade' => '1',
                    'documento'     => $vehicle->owner_document,
                    'data_nasc'     => $vehicle?->owner_birthday,
                    'nome'          => $vehicle->owner_name,
                    'mae'           => $vehicle->owner_mother_name,
                    'pai'           => 'Não Informado',
                    'rg'            => $vehicle->owner_rg,
                    'rg_uf'         => $vehicle->owner_rg_uf,
                    'rg_emissao'    => $vehicle->owner_rg_issue,
                ],
            ],
        ];
    }
}
