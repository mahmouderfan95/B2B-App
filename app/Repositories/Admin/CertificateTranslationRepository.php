<?php

namespace App\Repositories\Admin;

use Illuminate\Support\Str;
use Prettus\Repository\Eloquent\BaseRepository;

class CertificateTranslationRepository extends BaseRepository
{

    public function store($data_request, $certificate_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'certificate_id' => $certificate_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByCertificateId($certificate_id)
    {
        return $this->model->where('certificate_id',$certificate_id)->delete();
    }
    /**
     * Certificate Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\CertificateTranslation";
    }
}
