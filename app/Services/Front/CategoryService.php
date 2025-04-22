<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\Categories\CategoryResource;
use App\Http\Resources\Front\CategoryResource as CategoryRes;
use App\Models\Category;
use App\Repositories\Front\CategoryRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Http\Request;

class CategoryService
{
    use FileUpload, ApiResponseAble;

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     *
     * All  Categories.
     *
     */
    public function all(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        try {
            $categories = $this->categoryRepository->get_all($request, $lang);
            if (isset($categories) && count($categories) > 0) {
                return $this->listResponse(new CategoryResource($categories));
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     *
     *      details.
     *
     */
    public function details(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

        $categories = $this->categoryRepository->details($request, $lang, $id);

        if (isset($categories) && count($categories) > 0) {
            $categories = new CategoryRes($categories->first());
            return $this->listResponse($categories);
        } else {
            return $this->listResponse([]);
        }

    }

    public function tree(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        try {

             $categories = $id? Category::where('id',$id)->with(['child.child','translations'])
             ->get():
             Category::where('parent_id',null)->with(['child.child','translations'])->get();
             $categories = CategoryRes::collection( $categories);
            if (isset($categories) && count($categories) > 0) {
                return $this->listResponse($categories);
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

}
