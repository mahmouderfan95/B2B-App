<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderQuotation extends Model
{

    protected $fillable = [
        'client_id','special_order_id', 'quotation_price', 'expect_date_from',
        'expect_date_to','status','sender_type','vendor_id','is_expired'
    ];
    protected $casts = [
        'is_expired' => 'boolean'
    ];
    public function special_order(): BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class, 'special_order_id');
    }

    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class,'client_id');
    }

    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function histories() : HasMany
    {
        return $this->hasMany(OrderQuotationHistories::class,'order_quotation_id');
    }
    public function scopeIsNotExpired($query)
    {
        return $query->where('is_expired',false);
    }
}
