<?php

namespace App\Repositories\Front;

use Prettus\Repository\Eloquent\BaseRepository;

class CurrencyRepository extends BaseRepository
{


    public function getAllCurrencies(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('status','active')->get();
    }


    public function show($currency_id)
    {
        return $this->model->where('status','active')->find($currency_id);
    }

    /**
     * Currency Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Currency";
    }
}
