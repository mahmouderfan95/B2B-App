<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageTranslation extends Model
{
    protected $fillable = [
        'package_id',
        'language_id',
        'name',
    ];
    public $timestamps = false;

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
