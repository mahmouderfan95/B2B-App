<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class TypeTranslationRepository extends BaseRepository
{

    public function store($data_request, $type_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'type_id' => $type_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByTypeId($type_id)
    {
        return $this->model->where('type_id',$type_id)->delete();
    }
    /**
     * Type Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\TypeTranslation";
    }
}
