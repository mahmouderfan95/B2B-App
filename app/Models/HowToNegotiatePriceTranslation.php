<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowToNegotiatePriceTranslation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function HowToNegotiatePrice() : BelongsTo
    {
        return $this->belongsTo(HowToNegotiatePrice::class,'how_to_negotiate_id');
    }
}
