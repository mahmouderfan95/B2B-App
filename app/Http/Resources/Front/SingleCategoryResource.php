<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleCategoryResource extends JsonResource
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
            "sort_order"    => $this->sort_order,
            "status"        => $this->status,
        ];
    }
}
