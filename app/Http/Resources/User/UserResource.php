<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'driver_status_id'  => $this->driver_status_id,
            'name'              => $this->name,
            'email'             => $this->email,
            'phone'             => $this->phone,
            'document_1'        => $this->document_1,
            'document_2'        => $this->document_2,
            'gender'            => $this->gender,
            'mother_name'       => $this->mother_name,
            'father_name'       => $this->father_name,
            'notify'            => $this->notify,
            'newsletter'        => $this->newsletter,
            'register_complete' => $this->register_complete,
            'email_verified_at' => $this->email_verified_at,
            'last_activity'     => $this->last_activity,
            'home_dir'          => $this->home_dir,
            'first_time'        => $this->first_time,
            'accepted_terms'    => $this->accepted_terms,
            'user_agent'        => $this->user_agent,
            'ip'                => $this->ip,
            'ip'                => $this->address,
        ];
    }
}
