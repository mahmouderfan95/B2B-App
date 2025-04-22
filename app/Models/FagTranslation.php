<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FagTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function fag()
    {
        return $this->belongsTo(Fag::class);
    }
}
