<?php

namespace App\Repositories\Shipping;

use App\Enums\OrderStatus;
use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{

    public function public_orders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('type', 'public')->where('shipping_method','cif')->with(['client', 'products'])->get();
    }
    public function sample_orders()
    {
        return $this->model->where('type', 'sample')->where('status',OrderStatus::READY_TO_SHIP)->with(['client', 'products'])->get();
    }
    public function show($id)
    {
        return $this->model->where('id', $id)->where('shipping_method','cif')->with(['vendors', 'client', 'products'])->first();
    }

    /**
     * Order Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Order";
    }
}
