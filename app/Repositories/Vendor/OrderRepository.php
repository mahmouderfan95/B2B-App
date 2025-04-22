<?php

namespace App\Repositories\Vendor;

use Prettus\Repository\Eloquent\BaseRepository;

class OrderRepository extends BaseRepository
{


    public function getAllOrders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('type', 'sample')->with([ 'client', 'products'])
        ->whereHas('products', function($q){
            $q->where('order_products.vendor_id',auth('vendor')->id());
        })
        ->get();
    }


    public function public_orders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('type', 'public')->with([ 'client', 'products'])
            ->whereHas('products', function($q){
                $q->where('order_products.vendor_id',auth('vendor')->id());
            })
        ->get();
    }



    public function show($id)
    {
        return $this->model->where('id', $id)->with([ 'client', 'products'=>function($q){
            $q->where('products.vendor_id',auth('vendor')->id());
        }])->first();
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
