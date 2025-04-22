<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Language;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryRepository extends BaseRepository
{


    public function get_all($request, $lang): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $perPage = request()->input('per_page',15);
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
            ->where('parent_id', null)->paginate($perPage);
    }

    public function details($request, $lang, $id): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', app()->getLocale())->first();
        return $this->model->query()->where('id', $id)
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])
            ->get();
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
