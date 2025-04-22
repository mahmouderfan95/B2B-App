<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FastShippingTranslation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function fashShipping() :BelongsTo
    {
        return $this->belongsTo(FastShipping::class,'fast_shipping_id');
    }
}
