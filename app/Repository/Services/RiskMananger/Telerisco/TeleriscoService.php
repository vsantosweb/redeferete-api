<?php

namespace App\Repository\Services\RiskMananger\Telerisco;

use App\Repository\Interfaces\RiskManager\IRiskManagerRepository;

class TeleriscoService implements IRiskManagerRepository
{
    const SERVICE_NAME = 'TELERISCO';

    public function checkDriver(object $partner, object $vehicle)
    {
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
