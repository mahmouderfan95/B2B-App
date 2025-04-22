<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsTranslation extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $table ='about_us_translations';
    protected $fillable = [
        'language_id',
        'about_us_id',
        'name',
    ];

    public function about_us(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AboutUS::class);
    }
}
