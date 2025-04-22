<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HowToSpecialOrderTranslation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function HowToSpecialOrder() : BelongsTo
    {
        return $this->belongsTo(HowToSpecialOrder::class,'how_to_sp_order_id');
    }
}
