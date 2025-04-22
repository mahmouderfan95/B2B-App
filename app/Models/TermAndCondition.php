<?php

namespace App\Models;

use App\Traits\Trasnslated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TermAndCondition extends Model
{
    use HasFactory, Trasnslated;

    protected $guarded = [];
    protected $table = "terms_and_conditions";

    public function translations(): HasMany
    {
        return $this->hasMany(TermAndConditionTranslation::class);
    }
}
