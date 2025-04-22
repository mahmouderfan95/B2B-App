<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class BannerRepository extends BaseRepository
{


    public function getAllBanners(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }

    public function store($data_request)
    {
        $banner = $this->model->create($data_request);
        if ($banner)
            return $banner;

        return false;
    }

    public function update($data_request, $banner_id)
    {
        $banner = $this->model->find($banner_id);
        $banner->update($data_request);
        return $banner;
    }

    public function show($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
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
