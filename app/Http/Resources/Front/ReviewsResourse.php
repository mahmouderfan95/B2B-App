<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResourse extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id"      => $this->id,
            "rate"    => $this->rate,
            "comment" => $this->comment,
            "client"  => new ClientResource($this->client),
        ];
    }
}
