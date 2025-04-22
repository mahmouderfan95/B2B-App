<?php

namespace App\Http\Resources\Front\Drafts;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GetDraftAllDataResource extends JsonResource
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
            'category' => $this->product?->category?->name,
            'qty' => $this->quantity,
            'package' => $this->product?->package?->name
        ];
    }
}
