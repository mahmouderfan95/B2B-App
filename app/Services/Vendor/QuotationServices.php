<?php
namespace App\Services\Vendor;

use App\Events\Quotation\VendorSendQuotationToUser;
use App\Models\OrderQuotation;
use App\Models\OrderQuotationHistories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationServices{
    public function getAllQuotations()
    {
        $vendor = auth('vendor')->user();
        $data = OrderQuotation::where('vendor_id',$vendor->id)->get();
        return view('vendor.order-quotations.index',compact('data'));
    }

    public function getSendReplayPage($id)
    {
        $orderQuotation = OrderQuotation::find($id);
        return view('vendor.order-quotations.edit',compact('orderQuotation'));
    }
    public function postSendReplay(Request $request,$id)
    {
        // code
            DB::beginTransaction();
            // get order quotation by id
            $orderQuotation = OrderQuotation::find($id);
            // update order quotation data and insert new history for quotation
            $orderQuotation->update(['quotation_price' => $request->quotation_price]);
            // insert new history
            $quotationHistory = OrderQuotationHistories::create([
                'order_quotation_id' => $orderQuotation->id,
                'special_order_id' => $orderQuotation->special_order_id,
                'client_id' => $orderQuotation->client_id,
                'vendor_id' => $orderQuotation->vendor_id,
                'quotation_price' => $orderQuotation->quotation_price,
                'status' => $orderQuotation->status,
                'sender_type' => 'vendor'
            ]);
            // send notification to client
            event(new VendorSendQuotationToUser($orderQuotation));
            DB::commit();
            return redirect(route('vendor.quotations.index'))->with('success', true);
    }
}
