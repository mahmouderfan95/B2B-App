<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "key" => $this->key,
            "value" => $this->key == "config_setting_logo" ? asset('storage/uploads/settings/' . $this->value) : $this->value,
            // "type" => $this->type,
        ];
    }
}
