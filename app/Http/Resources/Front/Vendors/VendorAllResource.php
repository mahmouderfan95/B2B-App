<?php

namespace App\Http\Resources\Front\Vendors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorAllResource extends JsonResource
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
            'phone' => $this->phone,
            'another_phone' => $this->another_phone,
            'email' => $this->email,
            'description' => $this->description,
            'commercial_registration_number' => $this->commercial_registration_number,
            'image_commercial' => $this->image_commercial,
            'image_iban' => $this->image_iban,
            'image_mark' => $this->image_mark,
            'image_tax' => $this->image_tax,
            'expire_date_commercial_registration' => $this->expire_date_commercial_registration,
            'logo' => $this->logo,
            'status' => $this->status,
        ];
    }
}
