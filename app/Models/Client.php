<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable implements JWTSubject
{
    use Notifiable;
    protected $fillable = [
        'name',
        'image',
        'email',
        'phone',
        'another_phone',
        'password',
        'zip_code',
        'status',
    ];
    public $timestamps = false;
    public function cart() : HasOne
    {
        return $this->hasOne(Cart::class,'client_id');
    }
    public function reviews(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Review::class);
    }
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }
    public function client_addresses(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ClientAddress::class);
    }
    public function favorate_products()
    {
        return $this->belongsToMany(Product::class,'favorite_products');
    }
    public function scopeAccepted($q)
    {
        $q->where('status','accepted');
    }
    public function scopeVerified($q)
    {
        $q->where('is_email_verified' , 1);
    }

    public function getImageAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/clients' . '/' . $value);

        return url("images/no-image.png");
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
