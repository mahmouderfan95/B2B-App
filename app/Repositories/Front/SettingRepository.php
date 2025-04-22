<?php

namespace App\Repositories\Front;


use App\Models\Setting;
use Prettus\Repository\Eloquent\BaseRepository;

class SettingRepository extends BaseRepository
{


    public function getAllSettings(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function details($key)
    {
        return $this->model->where('key',$key)->first();
    }
    /**
     * Setting Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Setting";
    }
}
