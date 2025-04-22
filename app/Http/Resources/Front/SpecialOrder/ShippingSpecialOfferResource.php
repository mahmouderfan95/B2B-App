<?php

namespace App\Http\Resources\Front\SpecialOrder;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingSpecialOfferResource extends JsonResource
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
            'product_name' => $this->special_order->products->flatMap->translations->pluck('name')->first(),
            'qty' => $this->special_order->products->pluck('quantity')->first(),
            'special_order_status' => $this->special_order->status,
            'shipping_price' => $this->price,
            'total_price' => ($this->special_order->total + $this->price),
        ];
    }
}
