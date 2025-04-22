<?php

namespace App\Http\Resources\Front\Addresses;

use App\Http\Resources\Front\CityResource;
use App\Http\Resources\Front\CountryResource;
use App\Repositories\Front\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressesAllResource extends JsonResource
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
            "country"           => new CountryResource($this->country),
            "city"              => new CityResource($this->city),
            'city_id' => $this->city_id,
            'address' => $this->address,
            'phone' => $this->phone,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'zip_code' => $this->zip_code,
            'Port_details' => $this->Port_details,
            'country_id' => $this->country_id,
            'is_default' => $this->is_default
        ];
    }
}
