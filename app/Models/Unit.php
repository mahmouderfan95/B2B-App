<?php

namespace App\Models;

use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{

    use TranslatesName;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'sort_order',
    ];

    protected $append = [
        'name',
    ];
    public function translations(): HasMany
    {
        return $this->hasMany(UnitTranslation::class);
    }


    public function getNameAttribute($value)
    {
        $local = app()->getLocale();
        $lang = Language::where('code',$local)->first();
        return $this->translations->where('language_id', $lang->id)->first()?->name;
    }



}
