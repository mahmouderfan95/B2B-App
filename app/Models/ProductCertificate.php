<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCertificate extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'certificate_id',
    ];
    protected $table = 'product_certificate';

    public $timestamps = false;

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
