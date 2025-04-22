<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ShippingMethodRequest;
use App\Services\Admin\ShippingMethodService;

class ShippingMethodController extends Controller
{
    public $shippingMethodService;

    /**
     * ShippingMethod  Constructor.
     */
    public function __construct(ShippingMethodService $shippingMethodService)
    {
        $this->shippingMethodService = $shippingMethodService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->shippingMethodService->getAllShippingMethods($request);
    }

    /**
     * create shippingMethod page
     */
    public function create()
    {
        return $this->shippingMethodService->create();
    }

    /**
     *  Store ShippingMethod
     */
    public function store(ShippingMethodRequest $request)
    {
        return $this->shippingMethodService->storeShippingMethod($request);
    }

    /**
     * show the shippingMethod..
     *
     */
    public function show( $id)
    {
    }

    /**
     * edit the shippingMethod..
     *
     */
    public function edit(int $id)
    {
        return $this->shippingMethodService->edit($id);

    }

    /**
     * Update the shippingMethod..
     *
     */
    public function update(ShippingMethodRequest $request, int $id)
    {
        return $this->shippingMethodService->updateShippingMethod($request,$id);
    }
    /**
     * banned the ShippingMethod
     *
     */
    public function banned(int $id)
    {
        return $this->shippingMethodService->banned($id);

    }
    /**
     *
     * Delete ShippingMethod Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->shippingMethodService->deleteShippingMethod($id);

    }

}
