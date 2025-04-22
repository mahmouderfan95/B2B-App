<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{

    protected $guarded = [];
    public $timestamps = false;

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
