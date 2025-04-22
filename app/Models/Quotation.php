<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quotation extends Model
{

    protected $fillable = [
        'order_id', 'order_product_id', 'quotation_price', 'expect_date_from', 'expect_date_to','status'
    ];


    public function special_order(): BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class, 'order_id');
    }
}
