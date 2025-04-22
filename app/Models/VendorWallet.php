<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorWallet extends Model
{

    use HasFactory;
    protected $fillable = [
        'vendor_id', 'balance'
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function vendor_wallet_transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VendorWalletTransaction::class, 'vendor_wallet_id');
    }
}
