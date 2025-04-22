<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "country"           => new CountryResource($this->country),
            "city"              => new CityResource($this->city),
            "address"           => $this->address,
            "phone"             => $this->phone,
            "first_name"        => $this->first_name,
            "last_name"         => $this->last_name,
            "zip_code"          => $this->zip_code,
            "port_details"     => $this->Port_details,
            "is_default"       => $this->is_default,
            // "shipping_method"  => $this->shipping_method
        ];
    }
}
