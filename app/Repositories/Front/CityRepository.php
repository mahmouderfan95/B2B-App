<?php

namespace App\Repositories\Front;

use App\Models\Language;
use Prettus\Repository\Eloquent\BaseRepository;

class CityRepository extends BaseRepository
{


    public function index($request, $lang): \Illuminate\Database\Eloquent\Collection
    {
        $lang = Language::where('code', $lang)->first();
        return $this->model->query()
            ->whereHas('translations', function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            })
            ->when($request->has('country_id') && $request->country_id != "", function($q) use($request){
                $q->whereHas("region" , function ($query) use($request) {
                    $query->where('country_id', $request->country_id);
                });

            } )
            ->with(['translations' => function ($query) use ($lang) {
                $query->where('language_id', $lang->id);
            }])->get();
    }
    /**
     * Country Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\City";
    }
}
