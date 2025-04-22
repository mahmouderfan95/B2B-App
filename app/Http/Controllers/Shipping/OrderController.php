<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shipping\OrderStatusRequest;
use App\Http\Requests\Shipping\publicOrder\AddOffer;
use App\Services\Shipping\OrderService;
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
    public function public_orders(Request $request)
    {
        return $this->orderService->public_orders($request);
    }

    /**
     * show the order
     *
     */
    public function sample_orders(Request $request)
    {
        return $this->orderService->sample_orders($request);
    }
     public function show_public_orders($id)
    {
        return $this->orderService->show($id);
    }

    /** add new offer */
    public function addOffer(AddOffer $request)
    {
        return $this->orderService->addOffer($request);
    }
}
