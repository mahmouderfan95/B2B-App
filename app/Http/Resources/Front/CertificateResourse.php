<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class CertificateResourse extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id"           => $this->id,
            "name"         => $this->name,
            "image"         => $this->image,
        ];
    }
}
