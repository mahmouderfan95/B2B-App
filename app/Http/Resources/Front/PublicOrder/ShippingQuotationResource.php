<?php

namespace App\Http\Resources\Front\PublicOrder;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingQuotationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            "status" => $this->status,
            "expect_date_from" => $this->expect_date_from,
            "expect_date_to" => $this->expect_date_to,
            'order_status' => $this->order->status,
            'quotation_price' => $this->quotation_price,
            'total_price' => ($this->order->total + $this->quotation_price),
            'is_expired' => $this->is_expired
        ];
    }
}
