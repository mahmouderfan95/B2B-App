<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "phone" => $this->phone,
            "email" => $this->email,
            "facebook_link" => $this->facebook_link,
            "instagram_link" => $this->instagram_link,
            "twitter_link" => $this->twitter_link,
            "whatsapp_link" => $this->whatsapp_link,
            "address" => $this->translated?->address??"",
        ];
    }
}
