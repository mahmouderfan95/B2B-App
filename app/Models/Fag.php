<?php

namespace App\Models;

use App\Traits\Trasnslated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fag extends Model
{
    use HasFactory, Trasnslated;

    protected $guarded = [];

    public function translations(): HasMany
    {
        return $this->hasMany(FagTranslation::class);
    }
}
