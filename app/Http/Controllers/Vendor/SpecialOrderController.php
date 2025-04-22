<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendor\SpecialOrderRequest;
use App\Services\Vendor\SpecialOrderService;
use Illuminate\Http\Request;

class SpecialOrderController extends Controller
{
    public $specialOrderService;

    /**
     * SpecialOrder  Constructor.
     */
    public function __construct(SpecialOrderService $specialOrderService)
    {
        $this->specialOrderService = $specialOrderService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->specialOrderService->getAllSpecialOrders($request);
    }
    /**
     * show the specialOrder
     *
     */
    public function show($id)
    {
        return $this->specialOrderService->show($id);
    }
    /**
     * show the specialOrder
     *
     */
    public function acceptedByVendor($id)
    {
        return $this->specialOrderService->acceptedByVendor($id);
    }
    public function rejectByVendor($id)
    {
        return $this->specialOrderService->rejectByVendor($id);
    }
    public function readyForShip($id)
    {
        return $this->specialOrderService->readyForShip($id);
    }
    public function delivery($id)
    {
        return $this->specialOrderService->delivery($id);
    }
    public function add_total(Request $request)
    {
        return $this->specialOrderService->add_total($request);
    }
    /**
     * show the specialOrder
     *
     */
    public function accept(Request $request)
    {
        return $this->specialOrderService->accept($request);
    }
    /**
     * show the specialOrder
     *
     */
    public function refused(Request $request)
    {
        return $this->specialOrderService->refused($request);
    }
    /**
     * show the specialOrder
     *
     */
    public function shipping_offer_accept(Request $request)
    {
        return $this->specialOrderService->shipping_offer_accept($request);
    }
    /**
     * show the specialOrder
     *
     */
    public function shipping_offer_refused(Request $request)
    {
        return $this->specialOrderService->shipping_offer_refused($request);
    }


    /**
     *
     * Delete SpecialOrder Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->specialOrderService->deleteSpecialOrder($id);

    }

}
