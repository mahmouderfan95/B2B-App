<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\ProductImage;
use App\Services\Vendor\ProductService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public $productService;

    /**
     * Product  Constructor.
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function upload_image(Request $request)
    {
        $image_name = $this->productService->save_file($request->file, 'products');
        $image = ProductImage::create(['image' => $image_name]);

        return $image->id;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->productService->getAllProducts($request);
    }

    /**
     * create product page
     */
    public function create()
    {
        return $this->productService->create();
    }

    /**
     *  Store Product
     * @throws ValidationException
     */
    public function store(ProductRequest $request)
    {
        return $this->productService->storeProduct($request);
    }

    /**
     * show the product..
     *
     */
    public function show($id)
    {
        return 'dd';
    }

    /**
     * edit the product..
     *
     */
    public function edit(int $id)
    {
        
        return $this->productService->edit($id);

    }

    /**
     * Update the product..
     *
     */
    public function update(ProductRequest $request, int $id)
    {
        return $this->productService->updateProduct($request, $id);
    }

    /**
     *
     * Delete Product Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->productService->deleteProduct($id);

    }

}
