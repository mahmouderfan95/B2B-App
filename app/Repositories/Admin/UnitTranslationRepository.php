<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class UnitTranslationRepository extends BaseRepository
{

    public function store($data_request, $unit_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'unit_id' => $unit_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByUnitId($unit_id)
    {
        return $this->model->where('unit_id',$unit_id)->delete();
    }
    /**
     * Unit Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\UnitTranslation";
    }
}
