<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{


    public function getAllOrders(): \Illuminate\Database\Eloquent\Collection
    {
        $createdAt = request()->has('created_at') ? request()->get('created_at') : null;
        $status = request()->has('status') ? request()->get('status') : null;
        return $this->model->where('type', 'sample')->with(['client', 'products'])
            ->when($status && $status != null,fn($q) => $q->where('status',$status))
            ->when($createdAt && $createdAt != null,fn($q) => $q->where('created_at',$createdAt))
            ->get();
    }
    public function public_orders(): \Illuminate\Database\Eloquent\Collection
    {
        $createdAt = request()->has('created_at') ? request()->get('created_at') : null;
        $status = request()->has('status') ? request()->get('status') : null;
        return $this->model->where('type', 'public')->with(['client', 'products'])
            ->when($status && $status != null,fn($q) => $q->where('status',$status))
            ->when($createdAt && $createdAt != null,fn($q) => $q->where('created_at',$createdAt))
            ->orderBy('id','desc')
            ->get();
    }

    public function store($data_request)
    {
        $order = $this->model->create($data_request);
        if ($order)
            return $order;

        return false;
    }

    public function update($data_request, $order_id)
    {
        $order = $this->model->find($order_id);
        $order->update($data_request);
        return $order;
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with(['vendors', 'client', 'products'])->first();
    }


    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
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
