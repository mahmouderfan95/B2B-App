<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class LanguageRepository extends BaseRepository
{


    public function getAllLanguages(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function store($data_request)
    {
        return $this->model->create($data_request);
    }

    public function show($language_id)
    {
        return $this->model->find($language_id);
    }

    public function update($data_request, $language_id)
    {
        $language = $this->model->find($language_id);
        $language->update($data_request);
        return $language;
    }

    public function destroy($language_id)
    {
        return $this->model->find($language_id)->delete();
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
