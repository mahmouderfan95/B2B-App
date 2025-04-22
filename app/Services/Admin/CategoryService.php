<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\LanguageRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryService
{

    use FileUpload;

    private $categoryRepository;
    private $languageRepository;

    public function __construct(CategoryRepository $categoryRepository, LanguageRepository $languageRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Categories.
     *
     */
    public function getAllCategories($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $categories = $this->categoryRepository->getAllCategories($request);
            $categories = CategoryResource::collection($categories);
            return view("admin.categories.index", compact('categories'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Categories.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $categories = $this->categoryRepository->getAllCategoriesForm();
            $languages = $this->languageRepository->all();
            return view("admin.categories.create", compact('categories', 'languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Category.
     *
     * @return RedirectResponse
     */
    public function storeCategory(CategoryRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'categories');

        try {
            $category = $this->categoryRepository->store($data_request);
            if ($category)
                return redirect()->route('dashboard.categories.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $category = $this->categoryRepository->show($id);
            $categories = $this->categoryRepository->getAllCategoriesForm();
            $languages = $this->languageRepository->all();
            return view("admin.categories.edit", compact('category', 'categories', 'languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index');
        }
    }

    /**
     * Update Category.
     *
     * @param integer $category_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCategory(CategoryRequest $request, int $category_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image, 'categories');

        try {
            $category = $this->categoryRepository->update($data_request, $category_id);
            if ($category)
                return redirect()->route('dashboard.categories.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Category.
     *
     * @param int $category_id
     * @return RedirectResponse
     */
    public function deleteCategory(int $category_id): RedirectResponse
    {
        try {
            $category = $this->categoryRepository->show($category_id);
            if ($category) {
                $this->categoryRepository->destroy($category_id);
                return redirect()->route('dashboard.categories.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * restore Category.
     *
     * @param int $category_id
     * @return RedirectResponse
     */
    public function restore(int $category_id): RedirectResponse
    {
        try {
            $this->categoryRepository->restore($category_id);
            return redirect()->route('dashboard.categories.index')->with('success', true);

        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * trash Category.
     *
     * @param int $category_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function trash()
    {

        try {
            $trashes = $this->categoryRepository->trash();
            return view("admin.categories.trash", compact('trashes'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
