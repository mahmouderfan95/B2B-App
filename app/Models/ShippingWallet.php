<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingWallet extends Model
{
    protected $fillable = [
        'shipping_method_id',
        'balance',
    ];


    public function shipping_method(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class);
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function shipping_wallet_transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ShippingWalletTransaction::class,'shipping_wallet_id');
    }


}
