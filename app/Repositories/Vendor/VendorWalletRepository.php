<?php

namespace App\Repositories\Vendor;

use Prettus\Repository\Eloquent\BaseRepository;

class VendorWalletRepository extends BaseRepository
{


    public function show()
    {
        return $this->model->where('vendor_id',auth('vendor')->id())->with(['vendor','vendor_wallet_transactions'])->first();
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
