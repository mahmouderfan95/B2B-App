<?php

namespace App\Repositories\Front;

use App\Models\Product;
use Prettus\Repository\Eloquent\BaseRepository;

class CartRepository extends BaseRepository
{


    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->all();
    }


    public function show($banner_id)
    {
        return $this->model->find($banner_id);
    }

    public function getCartByClient($client_id)
    {
        return $this->model->where('client_id',$client_id)->first();
    }

    public function create(Array $data)
    {
        return $this->model->create($data);
    }

    public function getCartItems($cart)
    {
        return $cart->cartProduct()->with(['product','vendor'])->get();
    }

    public function addCartProducts($cart,Array $items)
    {
        $cart->products()->attach($items);
        return true;
    }

    public function removeCartProducts($cart,Array $items)
    {
        $cart->products()->detach($items);
        return true;
    }

    public function removeAllCartProducts($cart)
    {
        $cart->products()->detach();
        return true;
    }


    public function getCartTotal($cart)
    {
        return [
            'sub_total' => $cart->products->sum('price'),
            'product_count' => $cart->products->count(),
        ];
    }

    public function getCartSummary($cart)
    {
        return [
            'sub_total' => $cart->products->sum('sample_order_price'),
            'total' => $cart->products->sum('sample_order_price'),
            'product_count' => $cart->products->count(),
        ];
    }


    /**
     * Banner Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\Cart";
    }
}
