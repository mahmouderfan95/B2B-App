<?php

namespace App\Http\Controllers\Shipping;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\SpecialOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $auth = auth()->guard('shipping')->user();
        $auth = $auth->first();
        $customersCount = Client::where("status",'accepted')->count();
        $productsCount = Product::count();
        $sampleOrdersCount = Order::where('shipping_method_id',$auth->id)->where('status',OrderStatus::READY_TO_SHIP)->where('type','sample')->count();
        $publicOrdersCount = Order::where('type','public')
        ->where('status',OrderStatus::READY_TO_SHIP)
        ->where('shipping_method_id',$auth->id)->count();
        $spOrdersCount = SpecialOrder::where('shipping_method_id',$auth->id)->count();
        $bestSellingProduct = Product::TopSales()->take(5)->get();
        $latestSampleOrder = Order::Sample()->where('shipping_method_id',$auth->id)->orderBy('id','desc')->take(5)->get();
        $latestPublicOrder = Order::Public()->where('shipping_method_id',$auth->id)->orderBy('id','desc')->take(5)->get();
//        $latestSampleOrder = Order::Sample()->where('shipping_method_id',$auth->id)->orderBy('id','desc')->take(5)->get();
        return view('shipping.index',compact('auth','customersCount','productsCount','sampleOrdersCount',
            'publicOrdersCount','spOrdersCount','bestSellingProduct','latestPublicOrder','latestSampleOrder'));
    }
}
