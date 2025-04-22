<?php

namespace App\Repositories\Admin;

use App\Models\VendorWalletTransaction;
use Prettus\Repository\Eloquent\BaseRepository;

class VendorWalletTransactionRepository extends BaseRepository
{
    /**
     * Configure Repository the Model
     *
     * @return string
     */
    public function model() : string
    {
        return VendorWalletTransaction::class;
    }
}
