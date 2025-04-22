<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class Vendor extends Authenticatable
{

    use HasFactory, HasRoles,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_id',
        'name',
        'logo',
        'status',
        'street',
        'bank_name',
        'bank_account_number',
        'iban',
        'banned',
        'bank_id',
        'phone',
        'another_phone',
        'email',
        'website',
        'description',
        'commercial_registration_number',
        'image_commercial',
        'image_iban',
        'image_mark',
        'image_tax',
        'expire_date_commercial_registration',
        'password',
        'web_site',
        'vendor_name',
        'accept_terms',

    ];
    public function scopeTopSales($q)
    {
        return $q->orderBy('sales','desc');
    }
    public function country(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(Product::class);
    }

    public function orderProducts()
    {
        return $this->belongsToMany(Product::class,'order_products', 'vendor_id','order_id');
    }

    public function subVendor(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(SubVendor::class, 'vendor_id');
    }

    public function vendorWallet() : HasOne
    {
        return $this->hasOne(VendorWallet::class,'vendor_id');
    }

    public function bank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }

    // public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    // {
    //     return $this->hasMany(Order::class);
    // }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }



    public function getLogoAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/vendors' . '/' . $value);

        return url("images/no-image.png");
    }

    public function getImageCommercialAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/vendors' . '/' . $value);

        return url("images/no-image.png");
    }

    public function getImageIbanAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/vendors' . '/' . $value);

        return url("images/no-image.png");
    }

    public function getImageMarkAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/vendors' . '/' . $value);

        return url("images/no-image.png");
    }

    public function getImageTaxAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/vendors' . '/' . $value);

        return url("images/no-image.png");
    }

    public function scopeApproved($q)
    {
        $q->where('status', 'approved');
    }

    public function agreements(){
        return $this->hasMany(VendorAgreement::class, "vendor_id");
    }
}
