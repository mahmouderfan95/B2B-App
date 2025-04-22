<?php

namespace App\Models;

// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class VendorWalletTransaction extends Model
{
    // use InteractsWithMedia;

    protected $fillable = [
        'vendor_wallet_id', 'amount', 'operation_type', 'admin_id', 'receipt_url', 'reference', 'reference_id'
    ];

    public $appends = ["attachment_url"];

    public function wallet() {
        return $this->belongsTo(VendorWallet::class, 'vendor_wallet_id');
    }

    public function admin() {
        return $this->belongsTo(User::class, 'admin_id')->where('type', 'admin');
    }

}
