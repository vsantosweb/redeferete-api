<?php

namespace App\Services\Guep;

use App\Models\Driver\DriverPartnerContract;
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
        $data = $this->setData($partner->partner, $vehicle);

        /** @var Http $response */
        $responseSearch = json_decode($this->call('post', 'pesquisa/agregado', $data)->body());

        $reference = $responseSearch->message === 'Sucesso' ? $responseSearch->referencia : $partner->contracts()->get()->last()->ref
        ?? throw new \Exception('Error Processing Request: ' . $responseSearch->message, 1);

        $response = $this->getReference($reference);

        $contract = $response->data->registros[0];

        $driverPartnerContract = DriverPartnerContract::updateOrCreate(
            ['ref' => $contract->referencia],
            [
                'driver_partner_id' => $partner->id,
                'provider_name'     => self::SERVICE_NAME,
                'external_id'       => $contract->id,
                'status'            => $contract->laudo_conjunto_label,
                'issue_date'        => $contract->data_registro,
                'expire_at'         => now()->addYear(1),
            ]
        );

        $partner->status = $driverPartnerContract->status === 'ACORDO' ? 1 : 3;

        $partner->save();
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
