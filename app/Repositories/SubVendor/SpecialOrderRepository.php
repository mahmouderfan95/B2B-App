<?php

namespace App\Repositories\SubVendor;

use App\Models\OrderQuotation;
use App\Models\ShippingSpecialOffer;
use Prettus\Repository\Eloquent\BaseRepository;

class SpecialOrderRepository extends BaseRepository
{


    public function getAllSpecialOrders(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->where('vendor_id', auth('sub_vendor')->user()->vendor_id)->with(['client', 'products'])
            ->get();
    }

    public function show($id)
    {
        return $this->model->where('id', $id)->where('vendor_id', auth('sub_vendor')->user()->vendor_id)->with(['vendor', 'client', 'products', 'shipping_special_offers', 'order_quotations'])->first();
    }

    public function add_total($data_request)
    {
        $special_order = $this->model->find($data_request['special_order_id']);
        $special_order->total = $data_request['total'];
        $special_order->save();
        $quotation = OrderQuotation::create([
            'special_order_id' => $special_order->id,
            'quotation_price' => $special_order->total,
            'status' => 'pending',
            'sender_type' => 'vendor',
        ]);

        return $special_order;
    }
    public function accept($data_request)
    {
        $special_order = $this->model->find($data_request['special_order_id']);
        $special_order->total = $data_request['total'];
        $special_order->status = 'ready_to_ship';
        $special_order->save();
        $quotation = OrderQuotation::find($data_request['quotation_id']);
        $quotation->status = 'accepted';
        $quotation->save();
        return $special_order;
    }
    public function refused($data_request)
    {
        $special_order = $this->model->find($data_request['special_order_id']);
        $special_order->total = $data_request['total'];
        $special_order->status = 'paid_30';
        $special_order->save();
        $quotation = OrderQuotation::find($data_request['quotation_id']);
        $quotation->status = 'refused';
        $quotation->save();
        return $special_order;
    }
    public function shipping_offer_accept($data_request)
    {
        $special_order = $this->model->find($data_request['special_order_id']);
        $special_order->shipping_special_offer_id = $data_request['special_offer_id'];
        $special_order->save();
        $special_offer = ShippingSpecialOffer::find($data_request['special_offer_id']);
        $special_offer->status = 'accepted';
        $special_offer->save();
        $special_offer->where('id','!=',$data_request['special_offer_id'])->update(['status' => 'refused']);
        return $special_order;
    }
    public function shipping_offer_refused($data_request)
    {
        $special_order = $this->model->find($data_request['special_order_id']);
        $special_order->shipping_special_offer_id = NULL;
        $special_order->save();
        $special_offer = ShippingSpecialOffer::find($data_request['special_offer_id']);
        $special_offer->status = 'refused';
        $special_offer->save();
        return $special_order;
    }


    public function destroy($id)
    {
        return $this->model->where('id', $id)->delete();
    }

    /**
     * SpecialOrder Model
     *
     * @return string
     */
    public function model(): string
    {
        return "App\Models\SpecialOrder";
    }
}
