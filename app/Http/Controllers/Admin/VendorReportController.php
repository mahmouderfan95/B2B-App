<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Vendor;
use App\Services\Admin\VendorReportServices;
use Exception;
use Illuminate\Http\Request;

class VendorReportController extends Controller
{

    public function __construct(private VendorReportServices $orderReportService)
    {}
    public function vendorsOrders()
    {
        return $this->orderReportService->ordersBaseQuery();
    }
}
