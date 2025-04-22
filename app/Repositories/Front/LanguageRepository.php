<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class LanguageRepository extends BaseRepository
{


    public function getAllLanguages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('status','active')->get();
    }


    public function show($language_id)
    {
        return $this->model->where('status','active')->find($language_id);
    }

    /**
     * Language Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Language";
    }
}
