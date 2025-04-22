<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class SpecialOrderRepository extends BaseRepository
{


    public function getAllSpecialOrders(): \Illuminate\Database\Eloquent\Collection
    {
        $createdAt = request()->has('created_at') ? request()->get('created_at') : null;
        $status = request()->has('status') ? request()->get('status') : null;
        return $this->model->with(['client', 'products'])
            ->when($status && $status != null,fn($q) => $q->where('status',$status))
            ->when($createdAt && $createdAt != null,fn($q) => $q->where('created_at',$createdAt))
            ->get();
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with(['vendor', 'client', 'products', 'shipping_special_offers', 'order_quotations'])->first();
    }


    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * SpecialOrder Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\SpecialOrder";
    }
}
