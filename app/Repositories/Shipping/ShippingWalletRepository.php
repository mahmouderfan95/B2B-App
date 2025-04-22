<?php

namespace App\Repositories\Shipping;

use Prettus\Repository\Eloquent\BaseRepository;

class ShippingWalletRepository extends BaseRepository
{


    public function getAllShippingWallets(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['shipping_method', 'shipping_wallet_transactions'])->get();
    }

    public function show()
    {
        return $this->model->where('shipping_method_id', auth()->user()->id)->with(['shipping_method', 'shipping_wallet_transactions'])->first();
    }


    /**
     * ShippingWallet Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\ShippingWallet";
    }
}
