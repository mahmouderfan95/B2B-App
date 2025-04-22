<?php

namespace App\Services\Front\Order;

use App\Exceptions\Cart\cartBadUse;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\QualityResource;
use App\Repositories\Front\QualityRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Quality;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Traits\ApiResponseAble;
use Carbon\Carbon;

class SampleOrder
{
    use  ApiResponseAble;

    private Cart $cart;
    private OrderCalculations $orderCalculations;

    public function __construct(Cart $cart, $request )
    {
        $this->cart = $cart;
        $this->orderCalculations = new OrderCalculations($cart);
    }

    public function orderProcess()
    {
        $this->validateCart();
        $order = $this->genarateOrder();
        $this->deleteCart();
        return $order;
    }

    public function validateCart()
    {
        if( !isset($this->cart) || $this->cart ==null  ||  $this->cart->cartProduct->count() < 1){
            throw new cartBadUse(__('api.cart.cart_is_empty'), 400);
        }

        if($this->cart->client_address_id == null){
            throw new cartBadUse(__('api.cart.cart_address_not_set'), 400);
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
            "products_count" => $this->cart->productsCount,
            "sub_total"      => $this->orderCalculations->sample_sub_total,
            "total"          => $this->orderCalculations->total
        ]);
        return $this->createOrders($transaction);
    }


    private function createOrders($transaction)
    {
        $address = $this->cart->address;
        $order = Order::create([
            'transaction_id'    =>  $transaction->id,
            // 'vendor_id'         =>  $transaction->id,
            "client_id"         => auth('client')->id(),
            "client_address_id" => $address?->id,
            "city_id"           => $address?->city_id,
            "payment_method"    => "VISA",
            "shipping_method"   => $address?->shipping_method,
            "status"            => Transaction::REGISTERD ,
            "date"             => Carbon::now(),
            "type"              => "sample",
            "delivery_type"     => $address?->shipping_method ?? "shipping",
            "code"              => orderCode(),
            "sub_total"      => $this->orderCalculations->sample_sub_total,
            "total"          => $this->orderCalculations->total
        ]);
        $this->createOrderProducts($order);
        return $order;
    }


    private function createOrderProducts($order)
    {
        foreach($this->cart->cartProduct as $cartProduct)
        {
            $product = $cartProduct->product;
            $product->sample_order_quantity = $product->sample_order_quantity-1;
            $product->save();
            OrderProduct::create([
                    "order_id"    => $order->id,
                    "product_id" => $cartProduct->product_id,
                    "vendor_id"   => $cartProduct->vendor_id,
                    "quantity"   => $cartProduct->quantity,
                    "unit_price"  => $product->sample_order_price,
                    "total"       => $product->sample_order_price * $cartProduct->quantity,
            ]);
            $order->update(['vendor_id' => $product->vendor_id]);
            $order->vendors()->syncWithoutDetaching($product->vendor_id);
        }
    }



    public function deleteCart()
    {
        $this->cart->delete();
    }

}
