<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicyTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function privacyPolicy()
    {
        return $this->belongsTo(PrivacyPolicy::class);
    }
}
