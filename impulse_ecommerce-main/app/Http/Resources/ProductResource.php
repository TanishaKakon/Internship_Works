<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    // 'thumbnail_url' =>'storage/'.$this->thumbnail_url,
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'description' => $this->description,
            'photo' =>  $this->photo,
            'size' => $this->size,
            'stock' => $this->stock,
            'cat_id' => $this->cat_id,
            'brand_id' => $this->brand_id,
            'child_cat_id' => $this->child_cat_id,
            'is_featured' => $this->is_featured,
            'status' => $this->status,
            'condition' => $this->condition,
            'price' => $this->price,
            'discount' => $this->discount,
        ];
    }
}
