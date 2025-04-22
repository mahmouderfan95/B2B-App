<?php

namespace App\Repositories\Admin;

use App\Models\Category;
use App\Models\Language;
use Illuminate\Container\Container as Application;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{

    private $categoryTranslationRepository;

    public function __construct(Application $app, CategoryTranslationRepository $categoryTranslationRepository)
    {
        parent::__construct($app);

        $this->categoryTranslationRepository = $categoryTranslationRepository;

    }

    public function getAllCategories(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function trash(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    public function getAllCategoriesWithChild(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with('child')->whereNull('parent_id')->get();
    }

    public function getAllCategoriesForm(): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return Category::query()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            },
                'child' => function ($query) use ($lang) {
                    $query->with(['translations' => function ($q) use ($lang) {
                        $q->where('language_id', $lang->id);
                    }]);
                }])
            ->where('parent_id', null)->get();

    }


    public function store($data_request)
    {
        $level = 0;
        if (isset($data_request['parent_id'])) {
            $category_parent = $this->show($data_request['parent_id']);
            $level = $category_parent->level + 1;
        }
        $data_request['level'] = $level;
        $category = $this->model->create($data_request);
        if ($category)
            $this->categoryTranslationRepository->store($data_request['name'], $category->id);

        return $category;

    }

    public function update($data_request, $category_id)
    {
        $level = 0;
        if (isset($data_request['parent_id'])) {
            $category_parent = $this->show($data_request['parent_id']);
            $level = $category_parent->level + 1;
        }
        $data_request['level'] = $level;
        $category = $this->model->find($category_id);
        $category->update($data_request);
        $categoryTranslation = $this->categoryTranslationRepository->deleteByCategoryId($category->id);
        if ($categoryTranslation)
            $this->categoryTranslationRepository->store($data_request['name'], $category->id);
        return $category;

    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with('translations')->first();
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    public function restore($id)
    {
        return $this->model->withTrashed()->find($id)->restore();

    }

    /**
     * Category Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Category";
    }
}
