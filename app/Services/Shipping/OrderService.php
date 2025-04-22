<?php

namespace App\Services\Shipping;

use App\Helpers\FileUpload;
use App\Repositories\Shipping\OrderRepository;
use App\Http\Requests\Shipping\OrderStatusRequest;
use App\Http\Requests\Shipping\publicOrder\AddOffer;
use App\Models\ShippingQuotation;
use App\Models\SpecialOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;

class OrderService
{

    use FileUpload;

    private $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     *
     * All  public_orders.
     *
     */
    public function public_orders($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $orders = $this->orderRepository->public_orders($request);
            return view("shipping.orders.public", compact('orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function sample_orders($request)
    {
        try{
            $orders = $this->orderRepository->sample_orders($request);
            return view("shipping.orders.sample", compact('orders'));
        }catch(\Exception $exception){

        }
    }

    public function special_orders()
    {
        try {
            $special_orders = SpecialOrder::with('products')->get();
            return view("shipping.special_orders.index", compact('special_orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  orders
     */
    public function show($id)
    {
        try {
            $order = $this->orderRepository->show($id);
            return view("shipping.orders.show", compact('order'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    public function addOffer($data)
    {
        try{
            //create shipping public quotation
            ShippingQuotation::create([
                'shipping_method_id' => auth('shipping')->user()->id,
                'order_id' => $data['order_id'],
                'client_id' => $data['client_id'],
                'quotation_price' => $data['price'],
                'expect_date_from' => $data['expect_date_from'],
                'expect_date_to' => $data['expect_date_from'],
            ]);
            return redirect()->back()->with('success',true);
        }catch(Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

}
