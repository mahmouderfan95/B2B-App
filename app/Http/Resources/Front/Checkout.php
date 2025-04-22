<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Checkout extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
//            "id" => $this->id,
//            "code" => $this->code,
//            "date" => $this->date,
//            "payment_method" => $this->payment_method,
//            "total_tax" => $this->tax,
//            "total_vat" => $this->vat,
//            "sub_total" => $this->sub_total,
//            "total" => $this->total,
//            "status" => $this->status,
//            "products_count" => $this->products_count,
//            "products" => ProductResource::collection($this->products),
            'link' => "https://payments-dev.urway-tech.com/URWAYPGService/direct.jsp?paymentid=2400112360008152694"
        ];
    }
}
