<?php
namespace App\Services\Front;

use App\Models\ShippingSpecialOffer;
use App\Models\SpecialOrder;
use Illuminate\Http\Request;
use App\Traits\ApiResponseAble;
class SpecialShippingOfferService{
    use ApiResponseAble;
    public function acceptOffer(Request $request)
    {
        $special_order = SpecialOrder::find($request->special_order_id);
        $special_order->shipping_special_offer_id = $request->special_offer_id;
        $special_order->save();
        $special_offer = ShippingSpecialOffer::find($request->special_offer_id);
        $special_offer->status = 'accepted';
        $special_offer->save();
        return $this->listResponse($special_offer);
    }
}


?>
