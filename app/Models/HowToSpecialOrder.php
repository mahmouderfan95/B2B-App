<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Trasnslated;
class HowToSpecialOrder extends Model
{
    use HasFactory,Trasnslated;
    protected $guarded = [];
    public function translations() : HasMany
    {
        return $this->hasMany(HowToSpecialOrderTranslation::class,'how_to_sp_order_id');
    }
}
