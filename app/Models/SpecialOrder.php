<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpecialOrder extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "transaction_id",
        'vendor_id',
        'client_id',
        'client_address_id',
        'date',
        'status',
        'delivery_type',
        'payment_method',
        'shipping_method',
        'total',
        'sub_total',
        'vat',
        'tax',
        'code',
        'title',
        'date_from',
        'date_to',
        'delivery_fees'
    ];

    public function order_quotations(): HasMany
    {
        return $this->hasMany(OrderQuotation::class);
    }
    public function shipping_quotation() : HasMany
    {
        return $this->hasMany(ShippingQuotation::class,'special_order_id');
    }
    public function shipping_special_offers(): HasMany
    {
        return $this->hasMany(ShippingSpecialOffer::class,'special_order_id');
    }

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function client_address(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ClientAddress::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'special_order_products', "special_order_id")
            ->withPivot('id', 'quantity', 'updated_at');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }

}
