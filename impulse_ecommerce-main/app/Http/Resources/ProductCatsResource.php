<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $after_discount=($this->price-($this->price*$this->discount)/100);
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'summary' => $this->summary,
            'photo' => $this->photo,
            'discount' => $this->discount,
            'price' => $this->price,
            'after_discount' => $after_discount,
        ];
    }
}
