<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "logo" => $this->logo,
            "description" => $this->description,
            'wallet' => $this->vendorWallet
            //"products" => ProductResource::collection($this->products)
        ];
    }
}
