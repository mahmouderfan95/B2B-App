<?php
namespace App\Http\Resources\Front\PublicOrder;

use App\Http\Resources\Front\AddressResource;
use App\Http\Resources\Front\ProductResource;
use App\Http\Resources\Front\PublicOrder\ShippingQuotationResource;
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
            "delivery_fees" => $this->delivery_fees,
            "status" => $this->status,
            'shipping_method' => $this->shipping_method,
            "products_count" => count($this->products),
            'address' => new AddressResource($this->client_address),
            "products" => $this->relationLoaded('products') ? ProductResource::collection($this->products) : null,
            "shippingQuotation" => $this->relationLoaded('shipping_quotation') ? ShippingQuotationResource::collection($this->shipping_quotation) : null,
        ];
    }
}
