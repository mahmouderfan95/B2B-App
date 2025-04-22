<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class CategoryTranslationRepository extends BaseRepository
{

    public function store($data_request, $category_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'category_id' => $category_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                    'slug' =>  Str::slug($value, '-'),
                ]);
        }
        return true;
    }

    public function deleteByCategoryId($category_id)
    {
        return $this->model->where('category_id',$category_id)->delete();
    }
    /**
     * Category Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\CategoryTranslation";
    }
}
