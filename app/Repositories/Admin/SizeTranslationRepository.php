<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class SizeTranslationRepository extends BaseRepository
{

    public function store($data_request, $size_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'size_id' => $size_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteBySizeId($size_id)
    {
        return $this->model->where('size_id',$size_id)->delete();
    }
    /**
     * Size Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\SizeTranslation";
    }
}
