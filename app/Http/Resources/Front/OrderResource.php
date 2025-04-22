<?php

namespace App\Http\Resources\Front;

use App\Models\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "date" => $this->date,
            "payment_method" => $this->payment_method,
            "total_tax" => $this->tax,
            "total_vat" => $this->vat,
            "sub_total" => $this->sub_total,
            "total" => $this->total,
            "delivery_fees" => $this->delivery_fees,
            "status" => $this->status,
            'shipping_method' => $this->shipping_method,
            "products_count" => count($this->products),
            'address' => new AddressResource($this->client_address),
            "products" => ProductResource::collection($this->products)
        ];
    }
}
