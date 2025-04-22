<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingQuotation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'is_expired' => 'boolean'
    ];
    public function histories() : HasMany
    {
        return $this->hasMany(ShippingQuotationHistory::class,'shipping_quotation_id');
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
    public function scopeSpecialOrder($query)
    {
        return $query->where('order_id',null);
    }
    public function scopePublicOrder($query)
    {
        return $query->where('special_order_id',null);
    }
}
