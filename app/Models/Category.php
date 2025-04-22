<?php

namespace App\Models;

use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes, TranslatesName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'parent_id',
        'level',
        'status',
        'sort_order'
    ];



    public function translations(): HasMany
    {
        return $this->hasMany(CategoryTranslation::class);
    }


    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function child(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }

    public function getImageAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/categories' . '/' . $value);

        return url("images/no-image.png");
    }

    public function scopeActive($query)
    {
        return $query->where('status', "active");
    }

    public function scopeSubCategoriesCount(): int
    {
        return $this->child()->count();
    }

}
