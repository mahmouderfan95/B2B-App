<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class CurrencyRepository extends BaseRepository
{


    public function getAllCurrencies(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function store($data_request)
    {
        return $this->model->create($data_request);
    }

    public function show($currency_id)
    {
        return $this->model->find($currency_id);
    }

    public function update($data_request, $currency_id)
    {
        $currency = $this->model->find($currency_id);
        $currency->update($data_request);
        return $currency;
    }

    public function destroy($currency_id)
    {
        return $this->model->find($currency_id)->delete();
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
