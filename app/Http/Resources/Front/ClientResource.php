<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
            "phone" => $this->phone,
            "another_phone" => $this->another_phone,
            "zip_code" => $this->zip_code,
            "image"  => $this->image,
            "status" => !$this->is_email_verified ? "not_verified": $this->status
        ];
    }
}
