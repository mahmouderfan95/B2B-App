<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Banner extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'image',
        'sort_order',
    ];
    public function getImageAttribute($value): string
    {
        if (isset($value))
            return  asset('storage/uploads/banners'.'/'.$value);

        return url("images/no-image.png");
    }

}
