<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Trasnslated;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FastShipping extends Model
{
    use HasFactory,Trasnslated;
    protected $guarded = [];
    public function translations(): HasMany
    {
        return $this->hasMany(FastShippingTranslation::class);
    }
}
