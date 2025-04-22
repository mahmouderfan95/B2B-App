<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class AboutUsTranslationRepository extends BaseRepository
{

    public function store($data_request, $aboutUs_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'about_us_id' => $aboutUs_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByAboutUsId($aboutUs_id)
    {
        return $this->model->where('about_us_id',$aboutUs_id)->delete();
    }
    /**
     * AboutUs Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\AboutUsTranslation";
    }
}
