<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;

class ProductReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $product = Product::where('id', $this->product_id)->get();
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => ProductResource::collection($product),
            'rate' => $this->rate,
            'review' => $this->review,
            'status' => $this->status,

        ];
    }
}
