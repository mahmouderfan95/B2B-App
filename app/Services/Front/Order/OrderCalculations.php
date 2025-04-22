<?php

namespace App\Services\Front\Order;

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

class OrderCalculations
{
    use  ApiResponseAble;

    private Cart $cart;

    public $total_vat;
    public $total_tax;
    public $products_count;
    public $sub_total;
    public $sample_sub_total;
    public $total;

    public function __construct(Cart $cart,  )
    {
        $this->cart = $cart;
        $this->calculate();
    }


    public function calculate()
    {


        $this->sub_total= 0;

        $this->sample_sub_total = $this->cart->cartProduct
        //->filter(fn($c) => $c->product->vendor_id == $vendorId)
        ->sum(fn($c) => $c->quantity * ($c->product?->sample_order_price ?? 0));


        $this->total =
        $this->sample_sub_total
        + 0;

        $this->total_vat = 0;
        $this->total_tax = 0;
    }





}
