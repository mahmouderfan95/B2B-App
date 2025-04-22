<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class QualityRepository extends BaseRepository
{


    public function getAllLanguages()
    {
        return $this->model->paginate(10);
    }


    public function show($language_id)
    {
        return $this->model->find($language_id);
    }

    /**
     * Language Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Quality";
    }
}
