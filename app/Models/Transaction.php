<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    Const REGISTERD     = 'registered';
    Const PENDING       = 'pending';
    Const PARTIAL_PAID  = 'partial_paid';
    Const PAID          = 'paid';
    Const IN_DELEVERY   = 'in_delivery';
    Const DELIVERED     = 'delivered';
    Const COMPLETED     = 'completed';
    Const READY_TO_SHIP = 'ready_to_ship';
    protected $fillable = [
        'client_id', 'date', 'status', 'total', 'sub_total', 'total_vat', 'total_tax',
        'payment_method', 'code', 'products_count',
        'use_wallet',

    ];


    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            OrderProduct::class,
            Order::class,
            'transaction_id',
            'order_id',
        );
    }
}
