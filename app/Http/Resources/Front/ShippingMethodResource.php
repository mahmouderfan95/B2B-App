<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ShippingMethodResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "logo" => $this->logo,
            "email" => $this->email,
            "name" => $this->name,
            "status" => $this->status,
        ];
    }
}
