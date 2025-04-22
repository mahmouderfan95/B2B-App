<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingWalletTransaction extends Model
{
    protected $fillable = [
        'shipping_wallet_id',
        'user_id',
        'amount',
        'operation_type',
        'receipt_url',
        'reference',
        'reference_id',
    ];


    public function shipping_wallet(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingWallet::class);
    }


}
