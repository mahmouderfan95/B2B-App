<?php

namespace App\Http\Resources\Front\Countries;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryTranslationResource extends JsonResource
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
            'country_id' => $this->country_id,
            'language_id' => $this->language_id,
            'name' => $this->name
        ];
    }
}
