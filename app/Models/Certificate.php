<?php

namespace App\Models;

use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Certificate extends Model
{

    use  TranslatesName;
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
        return $this->hasMany(CertificateTranslation::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_certificate');

    }

    public function getImageAttribute($value): string
    {
        if (isset($value))
            return  asset('storage/uploads/certificates'.'/'.$value);

        return url("images/no-image.png");
    }

}
