<?php

namespace App\Http\Resources\Front\ShippingQuotations;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingQuotationPublicResource extends JsonResource
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
            'shipping_method' => $this->shippingMethod?->name,
            'public_order_id' => $this->order?->id,
            'public_order_code' => $this->order?->code,
            'quotation_price' => $this->quotation_price,
            'status' => $this->status,
            'expect_date_from' => $this->expect_date_from,
            'expect_date_to' => $this->expect_date_to,
            'is_expired' => $this->is_expired
        ];
    }
}
