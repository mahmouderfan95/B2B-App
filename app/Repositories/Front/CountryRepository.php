<?php

namespace App\Repositories\Front;

use App\Models\Language;
use Prettus\Repository\Eloquent\BaseRepository;

class CountryRepository extends BaseRepository
{


    public function index($request, $lang): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $perPage = request()->input('per_page',15);
        $lang = Language::where('code', $lang)->first();
        return $this->model->query()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])->paginate($perPage);
    }
    /**
     * Country Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Country";
    }
}
