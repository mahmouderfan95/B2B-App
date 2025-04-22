<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingOffer extends Model
{
    protected $fillable = [
        'shipping_method_id',
        'order_id',
        'price',
        'status',
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function shipping_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }

}
