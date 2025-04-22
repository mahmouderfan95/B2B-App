<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OrderRequest;
use App\Services\Admin\OrderService;
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
     * All Cats
     */
    public function public_orders(Request $request)
    {
        return $this->orderService->public_orders($request);
    }

    /**
     * create order page
     */
    public function create()
    {
    }

    /**
     *  Store Order
     */
    public function store(OrderRequest $request)
    {

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
