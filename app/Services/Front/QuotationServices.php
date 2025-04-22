<?php

namespace App\Services\Front;

use App\Enums\OrderStatus;
use App\Events\Quotation\SendUserNewQuotation;
use App\Http\Requests\Front\Quotations\UserUpdateStatus;
use App\Http\Requests\Front\SpOrder\SendQuotation;
use App\Models\OrderQuotation;
use App\Models\OrderQuotationHistories;
use App\Models\SpecialOrder;
use Illuminate\Http\Request;

class QuotationServices{
    public function sendQuotation(SendQuotation $request)
    {
        $data = $this->getOrderQuotationBySp($request->special_order_id);
        $request->merge(['vendor_id' => $data->vendor_id]);
        // check order exist in quotation
        if(OrderQuotation::where('special_order_id',$request->special_order_id)->where('client_id',auth('client')->user()->id)
        ->where('id',$request->order_quotation_id)
        ->where('status','pending')
        ->exists()){
            // get order_quotation
            $orderQuotation = OrderQuotation::where('id',$request->order_quotation_id)->where('special_order_id',$request->special_order_id)
            ->where('client_id',auth('client')->user()->id)->first();
            $orderQuotation->update([
                'quotation_price' => $request->quotation_price
            ]);
            // create quotation histories
            OrderQuotationHistories::create([
                'order_quotation_id' => $orderQuotation->id,
                'special_order_id' => $request->special_order_id,
                'client_id' => auth('client')->user()->id,
                'vendor_id' => $data->vendor_id,
                'quotation_price' => $request->quotation_price,
                'sender_type' => 'client'
            ]);
            return setResponseApi(true,200,'quotation send success to vendor',[]);
        }elseif(OrderQuotation::where('id',$request->order_quotation_id)->where('special_order_id',$request->special_order_id)->where('client_id',auth('client')->user()->id)
        ->where('status','!=','pending')->exists()){
            return setResponseApi(false,400,'Sorry, negotiations are complete regarding this request',[]);
        }else{
            $quotation = $this->createQuotation($request->all());
            // send notification to vendor
            event(new SendUserNewQuotation($quotation));
            return setResponseApi(true,200,'quotation send success to vendor',[]);
        }

    }
    public function VendorSend(Request $request)
    {
        $data = $this->getOrderQuotationBySp($request->special_order_id);
        $request->merge(['vendor_id' => $data->vendor_id]);
        // create order quotation sender vendor
        $quotation = $this->createVendorQuotation($request->all());
        // create order quotation history sender vendor
        $histories = OrderQuotationHistories::create([
            'order_quotation_id' => $quotation->id,
            'special_order_id' => $request->special_order_id,
            'client_id' => auth('client')->user()->id,
            'vendor_id' => $quotation->vendor_id,
            'quotation_price' => $request->quotation_price,
            'sender_type' => 'vendor'
        ]);
        return setResponseApi(true,200,'quotation send success to user',[]);
    }

    public function updateQuotationStatus(UserUpdateStatus $request)
    {
        $item = $this->getQuotationById($request->quotation_id);
        $sp = $this->getOrderQuotationBySp($request->special_order_id);
        try{
            if($item->status == 'accepted'){
                return setResponseApi(false,400,'You cannot update the negotiation status',[]);
            }elseif($item->status == 'refused'){
                return setResponseApi(false,400,'You cannot update the negotiation status',[]);
            }else{
                $item->update(['status' => $request->status]);
                $request->status == 'accepted' ? $sp->update(['status' => OrderStatus::ACCEPTED]): $sp->update(['status' => OrderStatus::CANCELED]);
            }
            // send notification to vendor after update status
            return setResponseApi(true,200,'quotation update status',[]);
        }catch(\Exception $exception){
            return setResponseApi(false,500,$exception->getMessage(),[]);
        }
    }

    private function createQuotation($data)
    {
        $client = auth('client')->user()->id;
        $quotation = OrderQuotation::create([
            'special_order_id' => $data['special_order_id'],
            'quotation_price' => $data['quotation_price'],
            'expect_date_from' => $data['expect_date_from'],
            'expect_date_to' => $data['expect_date_to'],
            'client_id' => $client,
            'sender_type' => 'client',
            'vendor_id' => $data['vendor_id']
        ]);

        return $quotation;
    }
    private function createVendorQuotation($data)
    {
        $client = auth('client')->user()->id;
        $quotation = OrderQuotation::create([
            'special_order_id' => $data['special_order_id'],
            'quotation_price' => $data['quotation_price'],
            'expect_date_from' => $data['expect_date_from'],
            'expect_date_to' => $data['expect_date_to'],
            'client_id' => $client,
            'sender_type' => 'vendor',
            'vendor_id' => $data['vendor_id']
        ]);

        return $quotation;
    }

    private function getQuotationById($id)
    {
        $orderQuotation = OrderQuotation::find($id);
        return $orderQuotation;
    }

    private function getOrderQuotationBySp($id)
    {
        $order = SpecialOrder::where('id',$id)->first();
        return $order;
    }
}
