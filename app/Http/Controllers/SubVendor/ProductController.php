<?php

namespace App\Http\Controllers\SubVendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\ProductImage;
use App\Services\SubVendor\ProductServices;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function __construct(public ProductServices $productServices)
    {

    }
    public function upload_image(Request $request)
    {
        $image_name = $this->productServices->save_file($request->file, 'products');
        $image = ProductImage::create(['image' => $image_name]);

        return $image->id;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->productServices->getAllProducts($request);
    }

    /**
     * create product page
     */
    public function create()
    {
        return $this->productServices->create();
    }

    /**
     *  Store Product
     * @throws ValidationException
     */
    public function store(ProductRequest $request)
    {
        return $this->productServices->storeProduct($request);
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

        return $this->productServices->edit($id);

    }

    /**
     * Update the product..
     *
     */
    public function update(ProductRequest $request, int $id)
    {
        return $this->productServices->updateProduct($request, $id);
    }

    /**
     *
     * Delete Product Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->productServices->deleteProduct($id);

    }
}
