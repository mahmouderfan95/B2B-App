<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SizeTranslation extends Model
{
    protected $fillable = [
        'size_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function size()
    {
        return $this->belongsTo(Size::class);
    }
}
