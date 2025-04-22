<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Category data into an array.
     *
     */
    public function toArray($request)
    {
        return [
            "category"    => new SingleCategoryResource($this->product->category),
            "type"        => new TypeResource($this->product->type),
            "unit"        => new UnitResource($this->product->unit),
            "vendor"      => new VendorDetailsResource($this->product->vendor),
            "certificate" => CertificateResourse::collection($this->product->certificates),
            "images"      => ProductImageResourse::collection($this->product->product_images),
            "reviews"     => ReviewsResourse::collection($this->product->reviews),
            "packages"    => [
                "type" => $this->product->package?->name ??  "",
                "size" => $this->product->size?->name    ??  ""
            ],
            "attributes" => collect($this->attributes)->groupBy('group.translations.0.name')->map(function ($group) {
                return $group->pluck("pivot.text",'translations.0.name');
            }),
            "id"        => $this->product->id,
            "name"      => $this->product->name,
            "image"     => $this->product->image,
            "price"     => $this->product->price,
            "sample_order_price" => $this->product->sample_order_price,
            "price_from" => $this->product->price_from,
            "price_to"   => $this->product->price_to,
            "quantity"   => $this->product->quantity,
            "status"     => $this->product->status,
            "is_organic" => $this->product->is_organic,
            "weight"     => $this->product->weight,
            "length"     => $this->product->length,
            "width"      => $this->product->width,
            "height"     => $this->product->height,
            "is_fav"     => $this->product->is_fav,
            "in_cart"     => $this->product->in_cart,
            "rate"       => $this->product->reviews_avg_rate??0,
            "review_count"     => $this->product->reviews_count ?? 0,
            "best_selling"     => 1,
        ];
    }
}
