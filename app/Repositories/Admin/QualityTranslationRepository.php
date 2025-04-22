<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class QualityTranslationRepository extends BaseRepository
{

    public function store($data_request, $quality_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'quality_id' => $quality_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByQualityId($quality_id)
    {
        return $this->model->where('quality_id',$quality_id)->delete();
    }
    /**
     * Quality Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\QualityTranslation";
    }
}
