<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\CategoryService;
use Illuminate\Http\Request;


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
     *  al cats
     */
    public function all(Request $request)
    {
        return $this->categoryService->all($request);
    }


    /**
     *  al cats
     */
    public function details(Request $request,$id)
    {
        return $this->categoryService->details($request,$id);
    }

    public function tree(Request $request,$id = null)
    {
        return $this->categoryService->tree($request,$id);
    }

}
