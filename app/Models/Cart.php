<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'client_address_id',
    ];


    public function cartProduct()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function Products() :BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity','vendor_id')
        ->withTimestamps();
    }

    public function address()
    {
        return $this->belongsTo(ClientAddress::class, "client_address_id");
    }


    public function getProductsCountAttribute($value)
    {
        return $this->cartProduct->sum(fn($cartProduct) => $cartProduct->quantity);
    }

}
