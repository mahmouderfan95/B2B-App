<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingSpecialOffer extends Model
{
    protected $fillable = [
        'shipping_method_id',
        'special_order_id',
        'price',
        'status',
    ];

    public function special_order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class);
    }

    public function shipping_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

}
