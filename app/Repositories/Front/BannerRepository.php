<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class BannerRepository extends BaseRepository
{


    public function getAllBanners(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function show($banner_id)
    {
        return $this->model->find($banner_id);
    }

    /**
     * Banner Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Banner";
    }
}
