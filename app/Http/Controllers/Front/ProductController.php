<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Product\AddReviewRequest;
use App\Services\Front\ProductService;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public $productService;


    /**
     * Product  Constructor.
     */
    public function __construct(ProductService $productService)
    {
        $this->middleware('auth:client', ['only' => ['addToFavorite', 'getFavorite',
            'removeFromFavorite', 'addReview']]);

        $this->productService = $productService;
    }


    /**
     *  best seller
     */
    public function best_seller(Request $request)
    {
        return $this->productService->best_seller($request);
    }

    /**
     *  lates
     */
    public function latest(Request $request)
    {
        return $this->productService->latest($request);
    }

    /**
     *  best seller
     */
    public function category(Request $request, $category_id)
    {
        return $this->productService->category($request, $category_id);
    }
    /**
     *  best seller
     */
    public function details(Request $request, $id)
    {
        return $this->productService->details($request, $id);
    }

    public function compare(Request $request, $id)
    {
        return $this->productService->compare($request, $id);
    }


    public function addToFavorite($product_id)
    {

        return $this->productService->addToFavorite($product_id);
    }

    public function removeFromFavorite($product_id)
    {
        return $this->productService->removeFromFavorite($product_id);
    }

    public function getFavorite()
    {
        return $this->productService->getFavorite();
    }

    public function addReview(AddReviewRequest $request)
    {
        return $this->productService->addReview($request->validated());
    }

    public function updateReview(AddReviewRequest $request, $review_id)
    {
        return $this->productService->updateReview($request->validated(), $review_id);
    }

    public function searchProducts(Request $request)
    {
        return $this->productService->searchProduct($request);
    }


}
