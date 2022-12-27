<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverPartnerResource extends JsonResource
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
            'uuid'           => $this->id,
            'uuid'           => $this->uuid,
            'driver_id'      => $this->driver->id,
            'vehicle_id'     => $this->vehicle->id,
            'status'         => $this->status,
            'brand'          => $this->vehicle->brand,
            'model'          => $this->vehicle->model,
            'licence_number' => $this->vehicle->licence_number,
            'licence_plate'  => $this->vehicle->licence_plate,
            'name'           => $this->driver->name,
            'email'          => $this->driver->email,
            'accepted_at'    => $this->accepted_at,
        ];
    }
}
