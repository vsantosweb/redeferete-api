<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestDriverResource extends JsonResource
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
            'status'      => $this->status,
            'accepted_at' => $this->accepted_at,
            'driver'      => $this->whenLoaded('driver', fn () => [
                'id'    => $this->driver->id,
                'name'  => $this->driver->name,
                'email' => $this->driver->email,
            ]),
            'vehicle' => $this->whenLoaded('vehicle', fn () => [
                'id'    => $this->vehicle->id,
                'brand' => $this->vehicle->brand,
                'model' => $this->vehicle->model,
            ]),
        ];
    }
}
