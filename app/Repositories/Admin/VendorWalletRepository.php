<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;

class VendorWalletRepository extends BaseRepository
{


    public function getAllVendorWallets(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->with(['vendor','vendor_wallet_transactions'])->get();
    }
    public function show($id)
    {
        return $this->model->where('vendor_id',$id)->with(['vendor','vendor_wallet_transactions'])->first();
    }


    /**
     * VendorWallet Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\VendorWallet";
    }
}
