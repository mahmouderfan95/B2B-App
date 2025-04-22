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
use App\Models\Product;
use App\Models\Quality;
use App\Models\Transaction;
use App\Repositories\Front\CartRepository;
use App\Traits\ApiResponseAble;
use Carbon\Carbon;

class PulicOrderCalculations
{
    use  ApiResponseAble;

    private  $request;

    public $total_vat;
    public $total_tax;
    public $products_count;
    public $sub_total;
    public $sample_sub_total;
    public $total;

    public function __construct( $request,)
    {
        $this->request = $request;
        $this->calculate();
    }


    public function calculate()
    {
        // dd($this->request['items']);
        foreach($this->request['items'] as $item){
            $product = Product::find($item['product_id']);
            $this->sample_sub_total= 0;
            $this->sub_total += $product->price *  $item['qty'];
            $this->total = $this->sub_total;

            $this->total_vat = 0;
            $this->total_tax = 0;
        }
        //->filter(fn($c) => $c->product->vendor_id == $vendorId)
        // ->sum(fn($c) => $c->quantity * ($c->product?->sample_order_price ?? 0));
    }





}
