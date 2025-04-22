<?php
namespace App\Services\Shipping;
use App\Enums\OrderStatus;
use App\Http\Requests\Shipping\AddOffer;
use App\Models\ShippingQuotation;
use App\Models\ShippingSpecialOffer;
use App\Models\SpecialOrder;
use Exception;
use Illuminate\Http\Request;

class SpecialOfferServices{
    public function index()
    {
        try {
            $SpecialOffers = ShippingQuotation::where('shipping_method_id',auth('shipping')->user()->id)
            ->where('order_id',null)
            ->get();
            return view("shipping.special_offers.index", compact('SpecialOffers'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function create()
    {
        try{
            $special_orders = SpecialOrder::where('status',OrderStatus::READY_TO_SHIP)->get();
            return view('shipping.special_offers.create',compact('special_orders'));
        }catch (\Exception $exception){
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function store(AddOffer $request)
    {
        try{
            $request->validated();
            $this->createSpecialOffer($request->validated());
            return redirect()->route('shipping.special-offers.index');
        }catch (\Exception $exception){
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function createSpecialOffer($data)
    {
        return ShippingSpecialOffer::create($data);
    }
}
