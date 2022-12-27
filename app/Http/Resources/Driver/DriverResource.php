<?php

namespace App\Http\Resources\Driver;

use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
            'id'                => $this->id,
            'uuid'              => $this->uuid,
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'gender'            => $this->gender,
            'document_1'        => $this->document_1,
            'document_2'        => $this->document_2,
            'status'            => $this->status,
            'birthday'          => $this->birthday,
            'notify'            => $this->notify,
            'newsletter'        => $this->newsletter,
            'email_verified_at' => $this->email_verified_at,
            'last_activity'     => $this->last_activity,
            'home_dir'          => $this->home_dir,
            'mother_name'       => $this->mother_name,
            'rg'                => $this->rg,
            'rg_issue'          => $this->rg_issue,
            'rg_uf'             => $this->rg_uf,
            'first_time'        => $this->first_time,
            'driver_status_id'  => $this->driver_status_id,
            'accepted_terms'    => $this->accepted_terms,
            'user_agent'        => $this->user_agent,
            'ip'                => $this->ip,
            'status'            => $this->status->name,
            'address'           => $this->whenLoaded('address', fn () => $this->address),
            'licence'           => $this->whenLoaded('licence', fn () => new DriverLicenceResource($this->licence)),
            'banks'             => $this->whenLoaded('banks', $this->banks),
            'vehicles'          => $this->whenLoaded('vehicles', fn () => $this->vehicles->load('type')),
            'created_at'        => $this->created_at->format('d-m-Y H:i'),
            'updated_at'        => $this->updated_at->format('d-m-Y H:i'),
        ];
    }
}
