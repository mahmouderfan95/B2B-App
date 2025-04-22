<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "client_id",
        'transaction_id',
        'client_address_id',
        'address_id',
        'vendor_id',
        'payment_method',
        'shipping_method',
        'shipping_method_id',
        'date',
        'type',
        'status',
        'delivery_type',
        'total',
        'sub_total',
        'vat',
        'tax',
        'code',
        'delivery_fees'
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }


    public function vendors()
    {
        return $this->belongsToMany(Vendor::class)->with('orderProducts');
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
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot('id', 'quantity', 'unit_price', 'total', 'updated_at');
    }

    public function scopeSample($query)
    {
        $query->where('type', 'sample');
    }
    public function scopePublic($query)
    {
        $query->where('type', 'public');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function orderVendors()
    {
        return $this->hasManyThrough(Product::class,OrderProduct::class,'id','product_id');
    }
    public function shipping_quotation() : HasMany
    {
        return $this->hasMany(ShippingQuotation::class,'order_id');
    }

}
