<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\SpecialOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $vendor = auth()->guard('vendor')->user();
        $agreement =  $vendor->agreements()->pending()->first();
        $productsCount = Product::where('vendor_id',$vendor->id)->count();
        $sampleOrdersCount = Order::where('vendor_id',$vendor->id)->where('type','sample')->count();
        $publicOrdersCount = Order::where('vendor_id',$vendor->id)->where('type','public')->count();
        $spOrdersCount = SpecialOrder::where('vendor_id',$vendor->id)->count();
        $bestSellingProduct = Product::where('vendor_id',$vendor->id)->TopSales()->take(5)->get();
        $latestSampleOrder = Order::where('vendor_id',$vendor->id)->where('type','sample')->take(5)->latest()->get();
        return view('vendor.index',compact('productsCount','sampleOrdersCount',
        'spOrdersCount','publicOrdersCount','bestSellingProduct','latestSampleOrder'))
        ->with(['auth' => $vendor,'agreement' => $agreement]);
    }

    public function subVendorIndex()
    {
        $subVendor = auth('sub_vendor')->user();
        $productsCount = Product::where('vendor_id',$subVendor->vendor->id)->count();
        $sampleOrdersCount = Order::where('vendor_id',$subVendor->vendor->id)->where('type','sample')->count();
        $publicOrdersCount = Order::where('vendor_id',$subVendor->vendor->id)->where('type','public')->count();
        $spOrdersCount = SpecialOrder::where('vendor_id',$subVendor->vendor->id)->count();
        $bestSellingProduct = Product::where('vendor_id',$subVendor->vendor->id)->TopSales()->take(5)->get();
        $latestSampleOrder = Order::where('vendor_id',$subVendor->vendor->id)->where('type','sample')->take(5)->latest()->get();
        return view('vendor.index',compact('productsCount','sampleOrdersCount',
            'spOrdersCount','publicOrdersCount','bestSellingProduct','latestSampleOrder'))
            ->with([
            'auth' => $subVendor
        ]);
    }

}
