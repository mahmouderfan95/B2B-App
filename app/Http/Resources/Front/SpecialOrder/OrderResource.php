<?php

namespace App\Http\Resources\Front\SpecialOrder;

use App\Http\Resources\Front\AddressResource;
use App\Http\Resources\Front\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
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
            "status" => $this->status,
            'shipping_method' => $this->shipping_method,
            "products_count" => $this->products_count,
            'address' => new AddressResource($this->client_address),
            "products" => $this->relationLoaded('products') ? ProductResource::collection($this->products) : null,
            "vendorQuotation" => $this->relationLoaded('order_quotations') ? VendorQuotationResource::collection($this->order_quotations) : null,
            "shippingQuotation" => $this->relationLoaded('shipping_quotation') ? ShippingQuotationResource::collection($this->shipping_quotation) : null,
        ];
    }
}
