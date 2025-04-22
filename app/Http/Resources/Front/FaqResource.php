<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "question" => $this->translated?->question ?? "",
            "answer"   => $this->translated?->answer ?? "",

        ];
    }
}
