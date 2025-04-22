<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class TermsAndConditionRepository extends BaseRepository
{


    public function index()
    {
        return $this->model->with(['translations'])->first();
    }



    /**
     * Language Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\TermAndCondition";
    }
}
