<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{

    protected $fillable = ['name', 'code', 'locale', 'image', 'directory', 'status', 'sort_order'];

    public function getImageAttribute($value)
    {
        if (isset($value))
            return  asset('/storage/uploads/languages'). '/'.$value;

        return  asset('/images/no-image.png');
    }
    public function categoryTranslations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}
