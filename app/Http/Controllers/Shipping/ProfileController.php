<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingMethodRequest;
use App\Services\Shipping\ShippingDashService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{

    private $shippingDashService;

    /**
     * Shipping  Constructor.
     */
    public function __construct(ShippingDashService $shippingDashService)
    {
        $this->shippingDashService = $shippingDashService;
    }

    /**
     * create shipping page
     */
    public function edit()
    {
        return $this->shippingDashService->editShipping();
    }

    /**
     * create shipping page
     */
    public function update(ShippingMethodRequest $request)
    {
        return $this->shippingDashService->updateShippingMethod($request, auth()->user()->id);
    }

}
