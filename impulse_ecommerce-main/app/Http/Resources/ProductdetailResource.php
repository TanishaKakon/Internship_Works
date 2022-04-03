<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\ProductReview;
use App\Models\Category;
use App\Http\Resources\ProductCatsResource;
use App\Http\Resources\ChildCategoryResource;

class ProductdetailResource extends JsonResource
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
        $rate=ProductReview::get()->where('product_id')->avg('rate');
        $rate_count=ProductReview::get()->where('product_id')->count();
        $category = Category::where('id',$this->cat_id)->get();
        $category_child = Category::where('id',$this->child_cat_id)->get();
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'photo' => $this->photo,
            'discount' => $this->discount,
            'price' => $this->price,
            'after_discount' => $after_discount,
            'size'=>$this->size,
            'rate'=>$rate,
            'rate_count'=>$rate_count,
            'cat_id'=>ProductCatsResource::collection($category),
            'child_cat' => ChildCategoryResource::collection($category_child),
            'status'=>$this->status,
            'stock' => $this->stock,
            'summary' => $this->summary,
            'description' => $this->description,
        ];
    }
}
