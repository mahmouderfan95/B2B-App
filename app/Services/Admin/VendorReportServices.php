<?php

namespace App\Services\Admin;

use App\Models\Order;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class VendorReportServices{

    public function ordersBaseQuery() {
        $vendors = Vendor::select('name','id')->get();
        $vendor = request()->has('vendor') ? request()->get('vendor') : null;
        $from = request()->has('from') ? request()->get('from') : null;
        $to = request('to') ? request('to') : null;
        $data = Order::query()
                ->with('vendor')
                ->when($vendor && $vendor !== null,fn($q) => $q->where('vendor_id',$vendor))
                ->when($from && $to,fn($q) => $q->whereBetween('created_at',[$from,$to]))
                ->orderBy('id','desc')
                ->paginate(50);
        // return $data;
        return view('admin.reports.vendors-orders',['vendors' => $vendors, 'data' => $data, 'vendor' => $vendor]);
    }
}
