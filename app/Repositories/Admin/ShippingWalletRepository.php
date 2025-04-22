<?php

namespace App\Repositories\Admin;

use App\Models\ShippingWalletTransaction;
use Prettus\Repository\Eloquent\BaseRepository;

class ShippingWalletRepository extends BaseRepository
{


    public function getAllShippingWallets(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['shipping_method', 'shipping_wallet_transactions'])->get();
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->with(['shipping_method', 'shipping_wallet_transactions'])->first();
    }

    public function add_balance($amount, $id)
    {
        $shipping_wallet = $this->model->find($id);
        $shipping_wallet->balance = $shipping_wallet['balance'] + $amount;
        if ($shipping_wallet->save())
        {
            ShippingWalletTransaction::create([
                'shipping_wallet_id' => $shipping_wallet->id,
                'user_id' => auth()->user()->id,
                'amount' => $amount,
                'operation_type' => 'in',
            ]);
        }
        return $shipping_wallet;
    }

    public function balance_deduction($amount, $id)
    {
        $shipping_wallet = $this->model->find($id);
        $shipping_wallet->balance = $shipping_wallet->balance - $amount;
        if ($shipping_wallet->save())
        {
            ShippingWalletTransaction::create([
                'shipping_wallet_id' => $shipping_wallet->id,
                'user_id' => auth()->user()->id,
                'amount' => $amount,
                'operation_type' => 'out',
            ]);
        }
        return $shipping_wallet;

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
