<?php

namespace App\Models;


use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class ShippingMethod extends Authenticatable
{

    use HasFactory,TranslatesName,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'logo',
        'email',
        'integration_key',
        'delivery_fees',
        'delivery_fees_covered_kilos',
        'additional_kilo_price',
        'cod_collect_fees',
        'status',
        'banned',
        'password',
    ];
    public function translations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(ShippingMethodTranslation::class);
    }
    public function shipping_offers(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(ShippingOffer::class);
    }

    public function shippingWallet() : HasOne
    {
        return $this->hasOne(ShippingWallet::class,'shipping_method_id');
    }
    public function getLogoAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/shipping_method' . '/' . $value);

        return url("images/no-image.png");
    }

    public function scopeApproved($q)
    {
        $q->where('status', 'approved');
    }
}
