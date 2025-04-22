<?php

namespace App\Services\SubVendor;

use App\Enums\OrderStatus;
use App\Helpers\FileUpload;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Order;
use App\Repositories\SubVendor\OrderRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class OrderService
{

    use FileUpload;
    public function __construct(public OrderRepository $orderRepository)
    {
    }

    /**
     *
     * All  Orders.
     *
     */
    public function getAllOrders($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $orders = $this->orderRepository->getAllOrders($request);
            return view("sub-vendor.orders.index", compact('orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
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
            return view("sub-vendor.orders.public", compact('orders'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Orders.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("sub-vendor.orders.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Order.
     *
     * @return RedirectResponse
     */
    public function storeOrder(OrderRequest $request): RedirectResponse
    {

    }

    /**
     * edit  orders
     */
    public function edit($id)
    {

    }

    /**
     * edit  orders
     */
    public function show($id)
    {
      //  try {
            $order = $this->orderRepository->show($id);
            if($order->type == 'sample')
                return view("vendor.orders.show-sample", compact('order'));

            if($order->type == 'public')
                return view("sub-vendor.orders.show", compact('order'));
        // } catch (Exception $e) {
        //     return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        // }
    }

    /**
     * Update Order.
     *
     * @param integer $order_id
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateOrder(OrderRequest $request, int $order_id, $destination = 'dashboard.orders.index'): RedirectResponse
    {

    }

    /**
     * Delete Order.
     *
     * @param int $order_id
     * @return RedirectResponse
     */
    public function deleteOrder(int $order_id): RedirectResponse
    {
        try {
            $order = $this->orderRepository->show($order_id);
            if ($order) {
                $this->orderRepository->destroy($order_id);
                return redirect()->route('sub-vendor.orders.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    public function rejectOrder($order_id)
    {
        $order = Order::where("id",$order_id)->where("status",OrderStatus::REGISTERD)->first();
        if($order)
        {
            $order->status = OrderStatus::REJECTED;
            $order->save();
        }
        return redirect()->back()->with('success', true);
    }

    public function approveOrder($order_id)
    {
        $order = Order::where("id",$order_id)->where("status", OrderStatus::REGISTERD)->first();
        if($order)
        {
            $order->status = OrderStatus::ACCEPTED;
            $order->save();
        }
        return redirect()->back()->with('success', true);
    }


    public function getOrderReady($order_id)
    {
        $order = Order::where("id",$order_id)->where("status", OrderStatus::PAID30)->first();
        if($order)
        {
            $order->status = OrderStatus::READY_TO_SHIP;
            $order->save();
        }
        return redirect()->back()->with('success', true);

    }

}
