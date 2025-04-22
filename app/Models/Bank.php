<?php

namespace App\Models;

use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use TranslatesName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(BankTranslation::class);
    }

    public function vendors(): HasMany
    {
        return $this->hasMany(Vendor::class);
    }

    public function getImageAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/banks' . '/' . $value);

        return url("images/no-image.png");
    }

}
