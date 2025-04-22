<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SpecialOrderRequest;
use App\Services\Admin\SpecialOrderService;
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
     *
     * Delete SpecialOrder Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->specialOrderService->deleteSpecialOrder($id);

    }

}
