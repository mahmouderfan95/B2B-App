<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class TransactionRepository extends BaseRepository
{


    public function getAllTransactions(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function show($id)
    {
        return $this->model->find($id);
    }

    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * Transaction Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Transaction";
    }
}
