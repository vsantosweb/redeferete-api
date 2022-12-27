<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverContractResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'                                => $this->id,
            'risk_manager'                      => $this->session->riskManager->name,
            'external_id'                       => $this->external_id,
            'ref'                               => $this->ref,
            'status'                            => $this->status,
            'issue_date'                        => $this->issue_date,
            'expire_at'                         => $this->expire_at,
            'requester_name'                    => $this->requester_name,
            'requester_email'                   => $this->requester_email,
            'requester_phone'                   => $this->requester_phone,
            'requester_document'                => $this->requester_document,
            'driver_name'                       => $this->driver_name,
            'driver_email'                      => $this->driver_email,
            'driver_phone'                      => $this->driver_phone,
            'driver_document_1'                 => $this->driver_document_1,
            'driver_gender'                     => $this->driver_gender,
            'driver_birthday'                   => $this->driver_birthday,
            'driver_address'                    => $this->driver_address,
            'driver_zipcode'                    => $this->driver_zipcode,
            'driver_licence_number'             => $this->driver_licence_number,
            'driver_licence_security_code'      => $this->driver_licence_security_code,
            'driver_licence_expire_at'          => $this->driver_licence_expire_at,
            'driver_licence_first_licence_date' => $this->driver_licence_first_licence_date,
            'driver_licence_uf'                 => $this->driver_licence_uf,
            'driver_licence_mother_name'        => $this->driver_licence_mother_name,
            'vehicle_brand'                     => $this->vehicle_brand,
            'vehicle_model'                     => $this->vehicle_model,
            'vehicle_licence_plate'             => $this->vehicle_licence_plate,
            'vehicle_licence_number'            => $this->vehicle_licence_number,
            'created_at'                        => $this->created_at,
            'hubs'                              => $this->whenLoaded('hubs', $this->hubs->map(fn($item) => [
                'id' => $item->id,
                'company_id' => $item->company_id,
                'code' => $item->code,
                'name' => $item->name,
                'geolocation' => $item->geolocation,
                'address' => $item->address,
                'driver_contract_id'=> $item->pivot->driver_contract_id,
                'company_hub_id'=> $item->pivot->company_hub_id,
                'approval_date'=> $item->pivot->approval_date,
                'distance'=> $item->pivot->distance,
                'company'=> $item->pivot->company,
            ]))
        ];
    }
}
