<?php

namespace App\Http\Resources\Front\Bancks;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAllResource extends JsonResource
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
            'image' => $this->image,
            'translations' => BankTranslationResource::collection($this->translations),
        ];
    }
}
