<?php

namespace App\Services\Shipping;

use App\Models\ShippingQuotation;
use App\Models\ShippingSpecialOffer;
use App\Models\SpecialOrder;
use Exception;
use GuzzleHttp\Psr7\Request;

class SpecialOrderService
{
    public function index()
    {
        try {
            $special_orders = SpecialOrder::with('products')
            ->get();
            return view("shipping.special_orders.index", compact('special_orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function show($id)
    {
        $specialOrder = SpecialOrder::findOrFail($id);
        return view('shipping.special_orders.show',compact('specialOrder'));
    }

    public function addOffer($data)
    {
        try{
            //create shipping sp quotation
            ShippingQuotation::create([
                'shipping_method_id' => auth('shipping')->user()->id,
                'special_order_id' => $data['special_order_id'],
                'client_id' => $data['client_id'],
                'quotation_price' => $data['price'],
                'expect_date_from' => $data['expect_date_from'],
                'expect_date_to' => $data['expect_date_from'],
            ]);
            return redirect()->back()->with('success',true);
        }catch(Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
