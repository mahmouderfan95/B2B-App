<?php

namespace App\Services\Front\Order;

use App\Enums\OrderStatus;
use App\Exceptions\Cart\cartBadUse;
use App\Exceptions\DataError;
use App\Models\Cart;
use App\Models\ClientAddress;
use App\Models\OrderProduct;
use App\Models\OrderQuotation;
use App\Models\Product;
use App\Models\SpecialOrder as ModelsSpecialOrder;
use App\Models\SpecialOrder as Order;
use App\Models\SpecialOrderProduct;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Traits\ApiResponseAble;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SpecialOrder
{
    use  ApiResponseAble;

    private  $request;
    private  $address_id;
    private PulicOrderCalculations $orderCalculations;

    public function __construct( $request )
    {
        // dd($request);
        $this->orderCalculations = new PulicOrderCalculations($request);
        $this->request = $request;
        $this->address_id = $request['client_address_id'];
    }

    public function orderProcess()
    {
        // $this->validateOrder();

        return $this->genarateOrder();

    }

    public function validateOrder()
    {
        foreach($this->request['items'] as $item){
            if(Product::where('id',$item['product_id'])->where('quantity','<=',$item['qty'])){
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
            "products_count" => count($this->request['items']),
            "sub_total"      => $this->orderCalculations->sub_total,
            "total"          => $this->orderCalculations->total
        ]);
         $this->createOrders($transaction);
    }


    private function createOrders($transaction)
    {
        // $address = auth('client')->user()->client_addresses()->where('is_default',1)->first();
        $address = ClientAddress::find($this->address_id);
        $order = ModelsSpecialOrder::create([
            'transaction_id'    =>  $transaction->id,
            'vendor_id'         =>  $this->request['vendor_id'],
            "client_id"         => auth('client')->id(),
            "client_address_id" => $address?->id ,
            // "city_id"           => $address?->city_id,
            "payment_method"    => "VISA",
            // "shipping_method"   => $address?->shipping_method ?? 'none',
            "status"            => Transaction::REGISTERD,
            'title' => request('title'),
            'date_from' => request('date_from'),
            'date_to' => request('date_to'),
            "date"              => Carbon::now(),
            "delivery_type"     => $address?->shipping_method ?? "shipping",
            "code"              => orderCode(),
            "sub_total"      => $this->orderCalculations->sub_total,
            "total"          => $this->orderCalculations->total,
            "vat"               => 0,
            "vax"             => 0,
        ]);

        $this->createOrderProducts($order);

        // return $order;
    }


    private function createOrderProducts($order)
    {
        foreach($this->request['items'] as $item){
            $product = Product::where('id',$item['product_id'])->first();
            // $product->quantity = $product->quantity-1;
            // $product->save();
            SpecialOrderProduct::create([
                    "special_order_id" => $order->id,
                    "product_id"  => $item['product_id'],
                    "vendor_id"   => $product->vendor_id,
                    "quantity"    => $item['qty'],
                    "unit_price"  => $product->price,
                    "total"       => $product->price * $item['qty'],
            ]);
        }

    }


    public Static function getSpecialOrders(Request $request)
    {
        $perPage = $request->per_page ?? 15;
        $orders =  ModelsSpecialOrder::where('client_id', auth('client')->id())
        ->with(['products'])
        ->orderBy('id','desc')
        ->paginate($perPage);
        $ordersByStatus =  ModelsSpecialOrder::where('client_id', auth('client')->id())
            ->where('status',$request->status)
            ->with(['products'])
            ->orderBy('id','desc')
            ->paginate($perPage);

        $data = $request->status ? $ordersByStatus : $orders;

        return $data;
    }

    public Static function getSpecialOrdersInProgress()
    {
        $orders =  ModelsSpecialOrder::where('client_id',auth('client')->id())
        ->where('status','in-progress')
        ->with(['products'])
        ->get();
        return $orders;
    }

    public Static function getSpecialOrdersInCompleted()
    {
        $orders =  ModelsSpecialOrder::where('client_id',auth('client')->id())
        ->where('status','completed')
        ->with(['products'])
        ->get();
        return $orders;
    }

    public static function getSpecialOrdersInRejected()
    {
        $orders =  ModelsSpecialOrder::where('client_id',auth('client')->id())
        ->where('status','rejected_by_vendor')
        ->with(['products'])
        ->get();
        return $orders;
    }

    public Static function getOrderOrFail($order_id)
    {
        $order = \App\Models\SpecialOrder::where('client_id',auth('client')->id())
        ->where('id',$order_id)
        ->first();

        if(!$order)
        {
            throw new DataError(" order not Found",400);
        }
        return $order;
    }


    public Static function chooseShippingMethod($order_id, $method)
    {
        $order = Self::getOrderOrFail($order_id,OrderStatus::ACCEPTED);
        $order->shipping_method = $method;
        if($method == 'xwork'){
            $order->status = OrderStatus::READY_FOR30;
        }
        $order->save();
        return $order;
    }

    public Static function partialPay($order_id)
    {
        $order = Self::getOrderOrFail($order_id,OrderStatus::READY_FOR30);
        // DB::beginTransaction();
        // $order->transaction->status = Transaction::PARTIAL_PAID;
        // $order->transaction->save();

        // $order->status = OrderStatus::PAID30;
        // $order->save();
        // DB::commit();
        return $order;
    }

    public Static function fullPay($order_id)
    {
        $order = Self::getOrderOrFail($order_id,OrderStatus::READY_TO_SHIP);
        // DB::beginTransaction();
        // $order->transaction->status = Transaction::PAID;
        // $order->transaction->save();

        // $order->status = OrderStatus::PAID;
        // $order->save();
        // DB::commit();
        return $order;
    }

}
