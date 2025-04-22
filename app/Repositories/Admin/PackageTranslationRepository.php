<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class PackageTranslationRepository extends BaseRepository
{

    public function store($data_request, $package_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'package_id' => $package_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByPackageId($package_id)
    {
        return $this->model->where('package_id',$package_id)->delete();
    }
    /**
     * Package Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\PackageTranslation";
    }
}
