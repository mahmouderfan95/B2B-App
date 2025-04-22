<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTranslation extends Model
{
    protected $fillable = [
        'bank_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function bank(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
