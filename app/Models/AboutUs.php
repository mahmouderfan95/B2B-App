<?php

namespace App\Models;

use App\Traits\Trasnslated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutUs extends Model
{


    use HasFactory, Trasnslated;

    protected $guarded = [];
    protected $table = 'about_us';
    protected $fillable = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(AboutUsTranslation::class,'about_us_id');
    }
}
