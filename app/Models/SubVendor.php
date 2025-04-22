<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class SubVendor extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $fillable = [
        "vendor_id",
        "name",
        "email",
        "password",
        "phone"
    ];

    protected $hidden = [
        'password',
    ];

    public function vendor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(vendor::class);
    }
}
