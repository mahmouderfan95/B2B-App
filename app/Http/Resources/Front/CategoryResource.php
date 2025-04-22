<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id"           => $this->id,
            "name"         => $this->name,
            "image"         => $this->image,
            "slug"          => $this->slug,
            "parent_id"     => $this->parent_id,
            "sort_order"    => $this->sort_order,
            "status"        => $this->status,
            "children"      => CategoryResource::collection($this->child),
        ];
    }
}
