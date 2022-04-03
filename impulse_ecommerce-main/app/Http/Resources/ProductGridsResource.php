<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductReview;


class ProductGridsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $after_discount = ($this->price - ($this->price * $this->discount) / 100);
        $rate = ProductReview::get()->where('product_id')->avg('rate');
        $rate_count = ProductReview::get()->where('product_id')->count();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'summary' => $this->summary,
            'slug' => $this->slug,
            'photo' => $this->photo,
            'discount' => $this->discount,
            'price' => $this->price,
            'after_discount' => $after_discount,
            'size' => $this->size,
            'rate' => $rate,
            'rate_count' => $rate_count
        ];
    }
}
