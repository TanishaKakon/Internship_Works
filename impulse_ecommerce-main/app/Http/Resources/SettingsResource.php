<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
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

            'id' => $this->id,
            'description' => $this->description,
            'short_des' => $this->short_des,
            'logo' => $this->logo,
            'photo' => $this->photo,
            'address' =>  $this->address,
            'phone' => $this->phone,
            'email' => $this->email,

        ];
    }
}
