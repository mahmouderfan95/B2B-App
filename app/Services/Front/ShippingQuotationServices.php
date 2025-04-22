<?php
namespace App\Services\Front;
use App\Enums\OrderStatus;
use App\Enums\QuotationStatus;
use App\Http\Requests\Front\Order\Public\SendShippingQuotationRequest;
use App\Http\Requests\Front\Order\Special\SendShippingQuotationRequest as SpecialSendShippingQuotationRequest;
use App\Http\Resources\Front\ShippingQuotations\ShippingQuotationPublicResource;
use App\Http\Resources\Front\ShippingQuotations\ShippingQuotationSpecialResource;
use App\Models\Order;
use App\Models\ShippingMethod;
use App\Models\ShippingQuotation;
use App\Models\ShippingWallet;
use App\Models\ShippingWalletTransaction;
use App\Models\SpecialOrder;
use App\Notifications\Shipping\AcceptSpecialOrderNotification;
use App\Notifications\Shipping\RefusedSpecialOrderNotification;
use App\Services\Payments\Urway\UrwayServices;
use App\Traits\ApiResponseAble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ShippingQuotationServices{
    use ApiResponseAble;
    public function getShippingQuotationSpecialOrder($id)
    {
        $shippingQuotations = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('special_order_id',$id)
            ->where('status',QuotationStatus::PENDING)
            ->get();
        if($shippingQuotations->count() > 0)
            return setResponseApi(true,200,'success message',ShippingQuotationSpecialResource::collection($shippingQuotations));
        return setResponseApi(false,400,'data not found',[]);
    }
    public function getShippingQuotationSpecialOrderDetails($id)
    {
        $shippingQuotation = $this->getShippingQuotationById($id);
        if($shippingQuotation)
            return setResponseApi(true,200,'success message',new ShippingQuotationSpecialResource($shippingQuotation));
        return setResponseApi(false,400,'data not found',[]);
    }
    public function acceptShippingQuotation($id,$sp_id)
    {
        DB::beginTransaction();
        $shippingQuotation = $this->getShippingQuotationSpOrderById($id,$sp_id);
        if($shippingQuotation){
            if($shippingQuotation->status == 'accept'){
                return setResponseApi(false,400,'You cannot update the negotiation status',[]);
            }elseif($shippingQuotation->status == 'refused'){
                return setResponseApi(false,400,'You cannot update the negotiation status',[]);
            }else{
                $shippingQuotation->update(['status' => QuotationStatus::ACCEPT]);
                // update special order status
                $specialOrder = $this->getSpecialOrderById($shippingQuotation->special_order_id)
                ->update(['status' => OrderStatus::READY_FOR30,'shipping_method_id' => $shippingQuotation->shipping_method_id,
                'total' => ($this->getSpecialOrderById($shippingQuotation->special_order_id)->total + $shippingQuotation->quotation_price),
                'delivery_fees' => $shippingQuotation->quotation_price]);
                // get shipping method
                $shippingMethod = ShippingMethod::where('id',$shippingQuotation->shippingMethod?->id)->first();
                // add quotation price in shipping wallet
                $shippingWallet = ShippingWallet::create(['shipping_method_id' => $shippingQuotation->shipping_method_id,'balance' => $shippingQuotation->quotation_price]);
                // create shipping wallet transaction
                ShippingWalletTransaction::create([
                    'shipping_wallet_id' => $shippingWallet->id,
                    'amount' => $shippingQuotation->quotation_price,
                    'operation_type' => 'in'
                ]);
                // send notification to shipping method
                Notification::send($shippingMethod,new AcceptSpecialOrderNotification($shippingQuotation));
                // log
                Log::channel('shipping-quotation')->info('shipping quotation status accepted by user and special order status is paid30' . $shippingQuotation);
                DB::commit();
                return $this->successResponse(200,new ShippingQuotationSpecialResource($shippingQuotation),'success message');
            }
        }
        return $this->listResponse([]);
    }
    public function refusedShippingQuotation($id,$sp_id)
    {
        DB::beginTransaction();
        $shippingQuotation = $this->getShippingQuotationSpOrderById($id,$sp_id);
        if($shippingQuotation){
            $shippingQuotation->update(['status' => QuotationStatus::REFUSED]);
            // update special order status
            $specialOrder = $this->getSpecialOrderById($shippingQuotation->special_order_id)->update(['status' => OrderStatus::CANCELED]);
            $shippingMethod = ShippingMethod::where('id',$shippingQuotation->shippingMethod?->id)->first();
            // send notification to shipping method
            Notification::send($shippingMethod,new RefusedSpecialOrderNotification($shippingQuotation));
            // log
            Log::channel('shipping-quotation')->info('shipping quotation status refused by user and special order status is cancel' . $shippingQuotation);
            DB::commit();
            return $this->successResponse(200,new ShippingQuotationSpecialResource($shippingQuotation),'success message');
        }
        return $this->listResponse([]);
    }

    public function getShippingQuotationPublicOrder($order_id)
    {
        $shippingQuotations = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('status',QuotationStatus::PENDING)
            ->where('order_id',$order_id)
            ->PublicOrder()
            ->get();
        if($shippingQuotations->count() > 0)
            return setResponseApi(true,200,'success message',ShippingQuotationPublicResource::collection($shippingQuotations));
        return setResponseApi(false,400,'data not found',[]);
    }
    public function getShippingQuotationPublicOrderDetails($id)
    {
        $shippingQuotation = $this->getShippingQuotationPublicById($id);
        if($shippingQuotation)
            return $this->listResponse(new ShippingQuotationPublicResource($shippingQuotation));
        return $this->listResponse();
    }
    public function acceptShippingQuotationPublicOrder($id,$order_id){
        $shippingQuotation = $this->getShippingQuotationByIdPending($id,$order_id);
        // if(!$shippingQuotation){
        //     return setResponseApi(false,400,'shipping quotation not found',[]);
        // }
        try{
            // check public order status
            $publicOrder = $this->getPublicOrderShippingMethodCif($order_id);
            // dd($publicOrder);
            if($publicOrder){
                if($shippingQuotation->status == 'accept'){
                    return setResponseApi(false,400,'You cannot update the negotiation status',[]);
                }elseif($shippingQuotation->status == 'refused'){
                    return setResponseApi(false,400,'You cannot update the negotiation status',[]);
                }else{
                    // update shipping quotation status to accepted
                    $shippingQuotation->update(['status' => QuotationStatus::ACCEPT]);
                    // add shipping method to order_id
                    // dd($shippingQuotation);
                    $publicOrder->update(['shipping_method_id' => $shippingQuotation->shipping_method_id,
                    'status' => OrderStatus::READY_FOR30,'total' => ($publicOrder->total + $shippingQuotation->quotation_price),
                    'delivery_fees' => $shippingQuotation->quotation_price]);
                    // dd($publicOrder->shipping_method_id);
                    Log::channel('shipping-quotation')->info('shipping quotation accepted' . $shippingQuotation);
                    // add quotation price in shipping wallet
                    $shippingWallet = ShippingWallet::create(['shipping_method_id' => $shippingQuotation->shipping_method_id,'balance' => $shippingQuotation->quotation_price]);
                    // create shipping wallet transaction
                    ShippingWalletTransaction::create([
                        'shipping_wallet_id' => $shippingWallet->id,
                        'amount' => $shippingQuotation->quotation_price,
                        'operation_type' => 'in'
                    ]);
                    return $this->successResponse(200,$shippingQuotation,'success message');
                }
            }
            return setResponseApi(false,400,'public order status not ' . OrderStatus::READY_FOR30 . 'or shipping method not cif',[]);
        }catch (\Exception $exception)
        {
            return $this->ApiErrorResponse('',$exception->getMessage());
        }
    }
    public function refusedShippingQuotationPublicOrder($id,$order_id){
        $shippingQuotation = $this->getShippingQuotationByIdPending($id,$order_id);
        if(!$shippingQuotation){
            return setResponseApi(false,400,'shipping quotation not found',[]);
        }
        // check public order status
        $publicOrder = $this->getPublicOrderShippingMethodCif($order_id);
        if($publicOrder) {
            // update shipping quotation status to refused
            $shippingQuotation->update(['status' => QuotationStatus::REFUSED]);
            Log::channel('shipping-quotation')->info('shipping quotation refused' . $shippingQuotation);
            // update public order status to cancel
            $publicOrder->update(['status' => OrderStatus::CANCELED]);
            Log::channel('shipping-quotation')->info('public order rejected shipping method and update status to canceled');
            return setResponseApi(true,200,'public order rejected shipping method',[]);
        }
        return setResponseApi(false,400,'public order shipping method is not cif',[]);
    }
    private function getShippingQuotationSpOrderById($id,$special_order_id)
    {
        $shippingQuotation = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('id',$id)
            ->where('special_order_id',$special_order_id)
            ->where('status','pending')
            ->first();
        return $shippingQuotation;
    }
    private function getShippingQuotationPublicOrderById($id,$order_id)
    {
        $shippingQuotation = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('id',$id)
            ->where('order_id',$order_id)
            ->first();
    }
    private function getShippingQuotationById($id)
    {
        $shippingQuotation = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('id',$id)
            ->first();
        return $shippingQuotation;
    }
    private function getShippingQuotationPublicById($id)
    {
        $shippingQuotation = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('id',$id)
            ->PublicOrder()
            ->first();
        return $shippingQuotation;
    }
    private function getShippingQuotationByIdPending($id,$order_id)
    {
        $shippingQuotation = ShippingQuotation::where('client_id',auth('client')->user()->id)
            ->where('id',$id)
            ->where('order_id',$order_id)
            ->where('status',QuotationStatus::PENDING)
            ->first();
        return $shippingQuotation;
    }

    private function getSpecialOrderById($id)
    {
        $specialOrder = SpecialOrder::where('id',$id)->first();
        return $specialOrder;
    }
    private function getPublicOrderById($id)
    {
        $publicOrder = Order::where('id',$id)->first();
        return $publicOrder;
    }

    private function getPublicOrderShippingMethodCif($id)
    {
        $publicOrder = Order::Public()
            ->where('shipping_method','cif')
            ->where('status',OrderStatus::ACCEPTED)
            ->where('id',$id)
            ->first();
        return $publicOrder;
    }
    public function shippingSendQuotation(SpecialSendShippingQuotationRequest $request)
    {
        $data = ShippingQuotation::create([
            'shipping_method_id' => $request->shipping_method_id,
            'client_id' => auth('client')->user()->id,
            'special_order_id' => $request->special_order_id,
            'quotation_price' => $request->quotation_price,
            'status' => 'pending',
            'expect_date_from' => $request->expect_date_from,
            'expect_date_to' => $request->expect_date_to,
        ]);
        return $this->listResponse($data);
    }
    public function shippingSendQuotationPublic(SendShippingQuotationRequest $request)
    {
        $data = ShippingQuotation::create([
            'shipping_method_id' => $request->shipping_method_id,
            'client_id' => auth('client')->user()->id,
            'order_id' => $request->order_id,
            'quotation_price' => $request->quotation_price,
            'status' => 'pending',
            'expect_date_from' => $request->expect_date_from,
            'expect_date_to' => $request->expect_date_to
        ]);
        return $this->listResponse($data);
    }
}
