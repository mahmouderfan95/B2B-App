<?php

namespace App\Http\Resources\Front\SpecialOrder;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorQuotationResource extends JsonResource
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
            'order_quotation_id' => $this->order_quotation_id,
            'special_order_id' => $this->special_order_id,
            'vendor_id' => $this->vendor_id,
            'vendor_name' => $this?->vendor->name,
            'quotation_price' => $this->quotation_price,
            'expect_date_from' => $this->orderQuotation->expect_date_from,
            'expect_date_to' => $this->orderQuotation->expect_date_to,
            'status' => $this->status,
            'sender_type' => $this->sender_type,
            'is_expired' => $this->orderQuotation->is_expired
        ];
    }
}
