<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class BankTranslationRepository extends BaseRepository
{

    public function store($data_request, $bank_id)
    {
        foreach ($data_request as $language_id => $value) {
             $this->model->create(
                [
                    'bank_id' => $bank_id,
                    'language_id' =>$language_id ,
                    'name' => $value,
                ]);
        }
        return true;
    }

    public function deleteByBankId($bank_id)
    {
        return $this->model->where('bank_id',$bank_id)->delete();
    }
    /**
     * Bank Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\BankTranslation";
    }
}
