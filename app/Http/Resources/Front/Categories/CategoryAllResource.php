<?php

namespace App\Http\Resources\Front\Categories;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'image' => $this->image,
            'level' => $this->level,
            'status' => $this->status,
            'translations' => CategoryTranslationResource::collection($this->translations)
        ];
    }
}
