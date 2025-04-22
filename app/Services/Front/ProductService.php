<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\PaginationResource;
use App\Http\Resources\Front\ProductResource;
use App\Http\Resources\Front\Products\ProductsResource;
use App\Http\Resources\Front\SingleProductResource;
use App\Models\Product;
use App\Repositories\Front\ProductRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
class ProductService
{
    use FileUpload, ApiResponseAble;

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     *
     * All  Products.
     *
     */
    public function best_seller(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

            $products = $this->productRepository->best_seller($request, $lang);
            $products = ProductResource::collection($products);
            if (isset($products) && count($products) > 0) {
                return $this->listResponse($products);
            } else {
                return setResponseApi(false,400,'data not found',[]);
                // return $this->listResponse([]);
            }

    }

    /**
     *
     *   Products latest.
     *
     */
    public function latest(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $products = $this->productRepository->latest($request, $lang);

            $products = ProductResource::collection($products);
            if (isset($products) && count($products) > 0) {
                return $this->listResponse($products);
            } else {
                return setResponseApi(false,400,'data not found',[]);
                // return $this->listResponse([]);
            }

    }

    /**
     *
     *   Products by category.
     *
     */
    public function category(Request $request, $category_id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $products = $this->productRepository->category($request, $lang, $category_id);

            $pagination = PaginationResource::make($products);
            if (count($products) > 0) {
                return $this->listResponse(new ProductsResource($products));
            } else {
                return setResponseApi(false,200,'data not found',[]);
                // return $this->listResponse([]);
            }
    }
    /**
     *
     *   Products details.
     *
     */
    public function details(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

        $products = $this->productRepository->details($request, $lang, $id);

        // collect($this->attributes)->groupBy('group.translations.0.name'),

            if (isset($products) ) {
                $products = new SingleProductResource($products);
                return $this->listResponse($products);
            } else {
                return setResponseApi(false,400,'product not found',[]);
                // return $this->listResponse([]);
            }
    }

    public function compare(Request $request, $product_id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $product = Product::find($product_id);

            $products = $product? $this->productRepository->category($request, $lang, $product->category_id)
                : new Collection();
            $products = ProductResource::collection($products);
            if (count($products) > 0) {
                return $this->listResponse($products);
            } else {
                return setResponseApi(false,400,'data not found',[]);
                // return $this->listResponse([]);
            }
    }

    public function addToFavorite($product_id)
    {
        $product = Product::find($product_id);
        if(!$product)
        {
            return $this->notFoundResponse();
        }
        auth('client')->user()->favorate_products()->syncWithoutDetaching($product->id);
        return $this->ApiSuccessResponse([],trans('api.product.added_to_favorate'));
    }

    public function removeFromFavorite($product_id)
    {
        $product = Product::find($product_id);
        if(!$product)
        {
            return $this->notFoundResponse();
        }
        auth('client')->user()->favorate_products()->detach($product->id);
        return $this->ApiSuccessResponse([],trans('api.product.removed_from_favorate'));
    }

    public function getFavorite()
    {
        $products = auth('client')->user()->favorate_products;
        $products = $products->count()? ProductResource::collection($products)
                : new Collection();
        return $this->ApiSuccessResponse($products);
    }

    public function addReview($data)
    {

        if($this->productRepository->currentUserRateProduct($data['product_id']))
        {
            return $this->ApiErrorResponse();
        }
        $review =  $this->productRepository->addreview($data);
        if($review)
            return $this->ApiSuccessResponse($review,trans('api.product.review_added'));

        return $this->ApiErrorResponse();
    }

    public function updateReview($data,$review_id)
    {

        $review = $this->productRepository->currentUserRateProduct($data['product_id']);
        if(!$review || $review->id != $review_id)
            return $this->ApiErrorResponse();

        $review =  $this->productRepository->upatereview($data,$review);
        if($review)
            return $this->ApiSuccessResponse($review,trans('api.product.review_added'));

        return $this->ApiErrorResponse();
    }

    public function searchProduct(Request $request)
    {
        $perPage = request()->input('per_page',15);
        $products = Product::whereHas('translations',function($q) use ($request){
            $q->where('name','like',"%{$request->search}%");
        })->paginate($perPage);
        if($products->count() > 0)
            return setResponseApi(true,200,'success message',new ProductsResource($products));
        return setResponseApi(true,200,'no search result',[]);
    }
}
