<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpecialOrderProduct extends Model
{

    protected $fillable = [
        'special_order_id', 'product_id', 'quantity','total','unit_price'
    ];

    public $timestamps = false;


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function special_order(): BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class, 'special_order_id');
    }
}
