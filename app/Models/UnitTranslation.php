<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitTranslation extends Model
{
    protected $fillable = [
        'unit_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
