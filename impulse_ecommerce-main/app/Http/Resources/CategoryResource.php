<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ChildCategoryResource;

class CategoryResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'summary' => $this->summary,
            'photo' => $this->photo,
            'is_parent' => $this->is_parent,
            'parent_id' => $this->parent_id,
            'added_by' => $this->added_by,
            'status' => $this->status,
            'child_cat' => ChildCategoryResource::collection($this->child_cat)
        ];
    }
}
