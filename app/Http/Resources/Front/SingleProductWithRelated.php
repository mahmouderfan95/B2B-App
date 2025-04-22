<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SingleProductWithRelated extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "category"    => new SingleCategoryResource($this->category),
            "type"        => new TypeResource($this->type),
            "unit"        => new UnitResource($this->unit),
            "vendor"      => new VendorDetailsResource($this->vendor),
            "certificate" => CertificateResourse::collection($this->certificates),
            "images"      => ProductImageResourse::collection($this->product_images),
            "reviews"     => ReviewsResourse::collection($this->reviews),
            "packages"    => [
                "type" => $this->package?->name ??  "",
                "size" => $this->size?->name    ??  ""
            ],
            "attributes" => collect($this->attributes)->groupBy('group.translations.0.name')->map(function ($group) {
                return $group->pluck("pivot.text",'translations.0.name');
            }),
            "id"        => $this->id,
            "name"      => $this->name,
            "image"     => $this->image,
            "price"     => $this->price,
            "sample_order_price" => $this->sample_order_price,
            "price_from" => $this->price_from,
            "price_to"   => $this->price_to,
            "quantity"   => $this->quantity,
            "status"     => $this->status,
            "is_organic" => $this->is_organic,
            "weight"     => $this->weight,
            "length"     => $this->length,
            "width"      => $this->width,
            "height"     => $this->height,
            "is_fav"     => $this->is_fav,
            "in_cart"     => $this->in_cart,
            "rate"       => $this->reviews_avg_rate??0,
            "review_count"     => $this->reviews_count ?? 0,
            "best_selling"     => 1,
        ];
    }
}
