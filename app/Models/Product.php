<?php

namespace App\Models;

use App\Traits\TranslatesName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use  TranslatesName;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'type_id', 'unit_id', 'vendor_id','size_id', 'package_id','is_organic', 'sample_order_price','sample_order_quantity', 'certificate_id', 'quality_id', 'image', 'price', 'price_from', 'price_to', 'quantity', 'is_visible', 'status', 'weight', 'length', 'width', 'height', 'sort_order'
    ];

    public $append = [
        "is_fav",
        "in_cart"
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ProductTranslation::class,'product_id');
    }

    public function product_images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function getRelatedProducts()
    {
        if ($this->category_id) {
            // Assuming a 'category' relationship exists
            $relatedProducts = self::where('category_id', $this->category_id)
                ->where('id', '!=', $this->id)
                ->take(8)
                ->get();

            return $relatedProducts;
        }

        return collect(); // No related products if no category is assigned
    }
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function certificates(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Certificate::class,'product_certificate');
    }
    public function attributes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Attribute::class,'product_attribute');
    }
    public function quality(): BelongsTo
    {
        return $this->belongsTo(Quality::class);
    }

    public function added_favorate()
    {
        return $this->belongsToMany(Client::class,'favorite_products');
    }

    public function added_cart()
    {
        return $this->belongsToMany(Product::class,'cart_product');
    }
    public function getImageAttribute($value): string
    {
        if (isset($value))
            return asset('storage/uploads/products' . '/' . $value);

        return url("images/no-image.png");
    }

    public function scopeFiltered($query, $request)
    {
        if($request->has('vendor_id') &&  $request->vendor_id!= ''){
            $query->vendorFilter(explode(',', $request->vendor_id));
        }
        if($request->has('quality_id') &&  $request->quality_id!= ''){
            $query->qualityFilter(explode(',', $request->quality_id));
        }
        if($request->has('certificate_id') &&  $request->certificate_id!= ''){
            $query->certificateFilter(explode(',', $request->certificate_id));
        }
        if($request->has('reviews') &&  $request->reviews!= ''){
            $query->reviewFilter(explode(',', $request->reviews));
        }
        if($request->has('unit_id') &&  $request->unit_id!= ''){
            $query->unitFilter(explode(',', $request->unit_id));
        }
        if($request->has('type_id') &&  $request->type_id!= ''){
            $query->typeFilter(explode(',', $request->type_id));
        }
        if($request->has('is_organic') &&  $request->is_organic!= ''){
            $query->IsOrganic($request->is_organic);
        }
        if($request->has('price_to') &&  $request->price_to != ''){
            $query->PriceTo($request->price_to);
        }
        if($request->has('price_from') &&  $request->price_from != ''){
            $query->PriceFrom($request->price_from);
        }
        if($request->has('sub_categories') &&  $request->sub_categories != '')
        {
            $query->sub_categoryFilter(explode(',', $request->sub_categories));
        }

    }

    public function scopeVendorFilter($query, $vendors)
    {
        $query->whereIn('vendor_id', $vendors);
    }
    public function scopeQualityFilter($query, $quality)
    {
        $query->whereIn('quality_id', $quality);
    }
    public function scopeUnitFilter($query, $units)
    {
        $query->whereIn('unit_id', $units);
    }
    public function scopeTypeFilter($query, $types)
    {
        $query->whereIn('type_id', $types);
    }
    public function scopeIsOrganic($query, $is_organic)
    {
        $query->where('is_organic', $is_organic);
    }
    public function scopeCertificateFilter($query, $certificates)
    {
        $query->whereIn('certificate_id', $certificates);
    }
    public function scopeReviewFilter($query, $reviews)
    {
        $query->whereHas('reviews', function($q)use($reviews){
            $q->whereIn('rate', $reviews);
        });
    }
    public function scopePriceFrom($query, $price_from )
    {
        $query->where('price_from', '>=', $price_from);
    }
    public function scopePriceTo($query, $price_to )
    {
        $query->where('price_to', '<=', $price_to);
    }
    public function scopeCategotyFilter($query, $categoty )
    {

        $categories = [$categoty];
        $cat = Category::with('child.child')->select('id')->find($categoty);

        if(isset($cat->child))
        foreach($cat->child as $sub_cat){
            $categories[] = $sub_cat->id;
            if($sub_cat->child){
                foreach($sub_cat->child as $item){
                    $categories[] = $item->id;
                }
            }
        }
        $query->whereIn('category_id', $categories);
    }

    public function scopeSub_categoryFilter($query, $sub_categories )
    {
        $query->whereIn('category_id', $sub_categories);
    }

    public function scopeShowable($query)
    {
        $query->where('status', "accepted");
        //->where('is_visible', 1)

    }

    public function getIsFavAttribute($value)
    {
        return  Auth('client')->id() == null ? false:
         $this->added_favorate->contains(auth('client')->user());
    }

    public function getInCartAttribute()
    {
        return $this->id == null ? false:
        $this->added_cart->contains($this->id);
    }

    public function scopeTopSales($q)
    {
        return $q->orderBy('sales','desc');
    }

}
