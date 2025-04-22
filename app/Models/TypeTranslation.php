<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeTranslation extends Model
{
    protected $fillable = [
        'type_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
