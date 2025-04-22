<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualityTranslation extends Model
{
    protected $fillable = [
        'quality_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function Quality()
    {
        return $this->belongsTo(Quality::class);
    }
}
