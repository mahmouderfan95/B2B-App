<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShippingQuotationHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function shippingQuotation() : BelongsTo
    {
        return $this->belongsTo(ShippingQuotation::class,'shipping_quotation_id');
    }
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function shippingMethod() : BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class,'shipping_method_id');
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function specialOrder() : BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class,'special_order_id');
    }
}
