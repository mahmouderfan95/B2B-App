<?php

namespace App\Http\Resources\Front\Products;

use App\Http\Resources\Front\CertificateResourse;
use App\Http\Resources\Front\ProductImageResourse;
use App\Http\Resources\Front\ReviewsResourse;
use App\Http\Resources\Front\SingleCategoryResource;
use App\Http\Resources\Front\TypeResource;
use App\Http\Resources\Front\UnitResource;
use App\Http\Resources\Front\VendorDetailsResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductAllResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"          => $this->id,
            "name"        => $this->name,
            "image"       => $this->image,
            "price"       => $this->price,
            "sample_order_price" => $this->sample_order_price,
            "price_from"  => $this->price_from,
            "price_to"    => $this->price_to,
            "quantity"    => $this->quantity,
            "status"      => $this->status,
            "is_organic"  => $this->is_organic,
            "weight"      => $this->weight,
            "length"      => $this->length,
            "width"       => $this->width,
            "height"      => $this->height,
            "is_fav"      => $this->is_fav,
            "rate"        => $this->reviews_avg_rate??0,
            "review_count"     => $this->reviews_count ?? 0,
            "best_selling"     => 1,
            "category"    => new SingleCategoryResource($this->category),
            "type"        => new TypeResource($this->type),
            "unit"        => new UnitResource($this->unit),
            "vendor"      => new VendorDetailsResource($this->vendor),
            "certificate" => CertificateResourse::collection($this->certificates),
            "images"      => ProductImageResourse::collection($this->product_images),
            "reviews"     => ReviewsResourse::collection($this->reviews),
        ];
    }
}
