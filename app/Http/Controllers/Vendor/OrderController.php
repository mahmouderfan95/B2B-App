<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Models\Order;
use App\Services\Vendor\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $orderService;

    /**
     * Order  Constructor.
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->orderService->getAllOrders($request);
    }
    /**
     * All public_orders
     */
    public function public_orders(Request $request)
    {
        return $this->orderService->public_orders($request);
    }


    public function approve($order_id)
    {
        return $this->orderService->approveOrder($order_id);
    }

    public function reject($order_id)
    {
        return $this->orderService->rejectOrder($order_id);
    }
    public function readyForShip($order_id)
    {
        return $this->orderService->readyForShip($order_id);
    }
    public function delivery($id)
    {
        return $this->orderService->delivery($id);
    }
    /**
     * show the order
     *
     */
    public function show($id)
    {
        return $this->orderService->show($id);
    }

    /**
     * edit the order..
     *
     */
    public function edit(int $id)
    {

    }


    /**
     * Update the order
     *
     */
    public function update(OrderRequest $request, int $id)
    {
        return $this->orderService->updateOrder($request, $id);
    }

    /**
     *
     * Delete Order Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->orderService->deleteOrder($id);

    }

}
