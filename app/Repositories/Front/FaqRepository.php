<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class FaqRepository extends BaseRepository
{


    public function index()
    {
        return $this->model->with(['translations'])->get();
    }



    /**
     * Language Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Fag";
    }
}
