<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateTranslation extends Model
{
    protected $fillable = [
        'certificate_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function certificate()
    {
        return $this->belongsTo(Certificate::class);
    }
}
