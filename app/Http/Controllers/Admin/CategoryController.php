<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;

class CategoryController extends Controller
{
    public $categoryService;

    /**
     * Category  Constructor.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->categoryService->getAllCategories($request);
    }

    /**
     * create category page
     */
    public function create()
    {
        return $this->categoryService->create();
    }

    /**
     *  Store Category
     */
    public function store(CategoryRequest $request)
    {

        return $this->categoryService->storeCategory($request);
    }

    /**
     * show the category..
     *
     */
    public function show( $id)
    {
        return $this->categoryService->trash();
    }

    /**
     * edit the category..
     *
     */
    public function edit(int $id)
    {
        return $this->categoryService->edit($id);

    }

    /**
     * Update the category..
     *
     */
    public function update(CategoryRequest $request, int $id)
    {
        return $this->categoryService->updateCategory($request,$id);
    }
    /**
     *
     * Delete Category Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->categoryService->deleteCategory($id);

    }
    /**
     *
     * trash Category
     *
     */
    public function trash()
    {
        return $this->categoryService->trash();

    }
    /**
     *
     * trash Category
     *
     */
    public function restore(int $id)
    {
        return $this->categoryService->restore($id);

    }

}
