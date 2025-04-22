<?php

namespace App\Services\Front\Order;

use App\Enums\OrderStatus;
use App\Exceptions\Cart\cartBadUse;
use App\Exceptions\DataError;
use App\Models\Cart;
use App\Models\ClientAddress;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\ShippingQuotation;
use App\Models\ShippingWallet;
use App\Models\ShippingWalletTransaction;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Traits\ApiResponseAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PublicOrder
{
    use  ApiResponseAble;

    private  $request;
    // private  $product;
    private  $address_id;

    private PulicOrderCalculations $orderCalculations;

    public function __construct( $request )
    {
        $this->orderCalculations = new PulicOrderCalculations($request);
        $this->request = $request;
        // $this->product = Product::find($request['product_id']);
        $this->address_id = $request['address_id'];
    }

    public function orderProcess()
    {
        $this->validateOrder();

        return $this->genarateOrder();

    }

    public function validateOrder()
    {
        foreach($this->request['items'] as $item){
            $product = Product::find($item['product_id']);
            if($product->quantity <= $item['qty']){
                throw new DataError(__('api.order.not_enough_quantity'), 400);
            }
        }
    }

    public function genarateOrder()
    {
        $transaction = Transaction::create([
            "client_id"      => auth('client')->id(),
            "date"           => Carbon::now(),
            "status"         => Transaction::REGISTERD ,
            "payment_method" => "VISA",
            "use_wallet"     => 0,
            "code"           => transactionCode(),
            "products_count" => 1,
            "sub_total"      => $this->orderCalculations->sub_total,
            "total"          => $this->orderCalculations->total
        ]);
         $this->createOrders($transaction);
    }


    private function createOrders($transaction)
    {
        // $address = auth('client')->user()->client_addresses()->where('is_default',1)->first();
        $address = ClientAddress::find($this->address_id);
        $order = Order::create([
            'transaction_id'    =>  $transaction->id,
            // 'vendor_id'         =>  $transaction->id,
            "client_id"         => auth('client')->id(),
            "client_address_id" => $address?->id ,
            "city_id"           => $address?->city_id,
            "payment_method"    => "VISA",
            "shipping_method"   => $address?->shipping_method ?? 'none',
            "status"            => Transaction::REGISTERD ,
            "date"              => Carbon::now(),
            "type"              => "public",
            "delivery_type"     => $address?->shipping_method ?? "shipping",
            "code"              => orderCode(),
            "sub_total"         => $this->orderCalculations->sub_total,
            "total"             => $this->orderCalculations->total
        ]);

        $this->createOrderProducts($order);

        // return $order;
    }


    private function createOrderProducts($order)
    {
        foreach($this->request['items'] as $item){
            $product = Product::find($item['product_id']);
            OrderProduct::create([
                "order_id"    => $order->id,
                "product_id"  => $product->id,
                "vendor_id"   => $product->vendor_id,
                "quantity"    => $item['qty'],
                "unit_price"  => $product->price,
                "total"       => $product->price * $item['qty'],
        ]);

        $order->vendors()->syncWithoutDetaching($product->vendor_id);
        $order->update(['vendor_id' => $product->vendor_id]);
        // return $order;
    }


    }
    public Static function getPublicOrders(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $orders =  Order::where('client_id',auth('client')->id())
            ->where('type', 'public')
            ->with(['products'])
            ->orderBy('id','desc')
            ->paginate($perPage);
        $ordersByStatus =  Order::where('client_id',auth('client')->id())
                ->where('type', 'public')
                ->where('status',$request->get('status'))
                ->with(['products'])
                ->orderBy('id','desc')
                ->paginate($perPage);
        $data =  $request->status ? $ordersByStatus : $orders;
        return $data;
    }

    public Static function getOrderOrFail($order_id, $status = null)
    {
        $order = Order::where("type", 'public')
        ->where('client_id', auth('client')->id())
        ->where('id',$order_id)
        ->when($status != null, function($q) use($status){
            $q->where('status', $status);
        })
        ->first();

        if(!$order)
        {
            throw new DataError(" order not Found",400);
        }
        return $order;
    }


    public Static function chooseShippingMethod($order_id, $method)
    {
        $order = Self::getOrderOrFail($order_id ,OrderStatus::ACCEPTED);
        $order->shipping_method = $method;
        if($method == 'xwork'){
            $order->status = OrderStatus::READY_FOR30;
        }
        $order->save();
        return $order;
    }

    public Static function partialPay($order_id)
    {
        $order = Self::getOrderOrFail($order_id, OrderStatus::READY_FOR30);
//        DB::beginTransaction();
//        $order->transaction->status = Transaction::PARTIAL_PAID;
//        $order->transaction->save();
//        $order->status = OrderStatus::PAID30;
//        $order->save();
//        DB::commit();
        return $order;
    }

    public Static function fullPay($order_id)
    {
        $order = Self::getOrderOrFail($order_id,OrderStatus::READY_TO_SHIP);
//        DB::beginTransaction();
//        $order->transaction->status = Transaction::PAID;
//        $order->transaction->save();
//
//        $order->status = OrderStatus::PAID;
//        $order->save();
//        DB::commit();
        return $order;
    }
    public Static function readyToShip($order_id)
    {
        $order = Self::getOrderOrFail($order_id, OrderStatus::PAID30);
        try{
            DB::beginTransaction();
            $order->transaction->update(['status' => Transaction::READY_TO_SHIP]);
            $order->update(['status' => OrderStatus::READY_TO_SHIP]);
            DB::commit();
            return $order;
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->ApiErrorResponse('',$exception->getMessage());
        }
    }

    public Static function delivered($order_id)
    {
        $order = self::getOrderOrFail($order_id,OrderStatus::PAID);
        try{
            DB::beginTransaction();
            $order->transaction->update(['status' => Transaction::DELIVERED]);
            $order->update(['status' => OrderStatus::DELIVERED]);
            // add delivery fees in shipping wallet
            $shippingMethod = ShippingMethod::where('id',$order->shipping_method_id)->first();
            $quotationPrice = ShippingQuotation::where('order_id',$order->id)->where('status','accept')->select('id','quotation_price')->first();
            $wallet = ShippingWallet::create([
                'shipping_method_id' => $shippingMethod->id,
                'balance' => $quotationPrice->quotation_price
            ]);
            // create wallet transaction
            $walletTransaction = ShippingWalletTransaction::create([
                'shipping_wallet_id' => $wallet->id,
                'user_id' => $order->client_id,
                'shipping_method_id' => $shippingMethod->id,
                'balance' => $quotationPrice->quotation_price,
                'amount' => $wallet->balance,
                'operation_type' => 'in'
            ]);
            DB::commit();
            return $order;
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->ApiErrorResponse('',$exception->getMessage());
        }
    }

    public Static function shippingDone($order_id)
    {
        $order = self::getOrderOrFail($order_id,OrderStatus::DELIVERED);
        try{
            DB::beginTransaction();
            $order->transaction->update(['status' => OrderStatus::COMPLETED]);
            $order->update(['status' => OrderStatus::COMPLETED]);
            DB::commit();
            return $order;
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return $this->ApiErrorResponse('',$exception->getMessage());
        }
    }

}
