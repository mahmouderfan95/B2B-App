<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderQuotationHistories extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function orderQuotation() : BelongsTo
    {
        return $this->belongsTo(OrderQuotation::class,'order_quotation_id');
    }
    public function specialOrder() : BelongsTo
    {
        return $this->belongsTo(SpecialOrder::class,'special_order_id');
    }
    public function vendor() : BelongsTo
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
