<?php

namespace App\Repositories\Front;

use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Psy\Readline\Transient;

class TransactionRepository extends BaseRepository
{


    public function currentClinetSampleOrders(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $orders =  Order::where('client_id', auth('client')->id())
        ->where('type', 'sample')
        ->with(['products'])->orderBy('id','desc')
        ->paginate($perPage);
        $ordersStatus =  Order::where('client_id', auth('client')->id())
            ->where('type', 'sample')
            ->where('status',$request->status)
            ->with(['products'])
            ->orderBy('id','desc')
            ->paginate($perPage);
        $checkStatus =  $request->status ? $ordersStatus : $orders;
        return $checkStatus;
    }

    public function model(): string
    {
        return "App\Models\Transaction";
    }
}



