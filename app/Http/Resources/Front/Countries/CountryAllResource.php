<?php

namespace App\Http\Resources\Front\Countries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryAllResource extends JsonResource
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
            'code' => $this->code,
            'flag' => $this->flag,
            'vat' => $this->vat,
            'translations' => CountryTranslationResource::collection($this->translations),
        ];
    }
}
