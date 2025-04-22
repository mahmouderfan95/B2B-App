<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingMethodTranslation extends Model
{
    protected $fillable = [
        'shipping_method_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function shipping_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }
}
