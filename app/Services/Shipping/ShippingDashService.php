<?php

namespace App\Services\Shipping;

use App\Helpers\FileUpload;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShippingMethodRequest;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Shipping\ShippingMethodRepository;
use Exception;
use Illuminate\Http\RedirectResponse;

class ShippingDashService extends Controller

{

    use FileUpload;
    private $shippingMethodRepository;
    private $languageRepository;

    public function __construct(ShippingMethodRepository $shippingMethodRepository,LanguageRepository $languageRepository)
    {
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->languageRepository = $languageRepository;
    }
    /**
     * edit  shipping
     */
    public function editShipping()
    {
        try {
            $languages  = $this->languageRepository->all();
            $shippingMethod = $this->shippingMethodRepository->show();
            return view("shipping.profile.edit", compact('shippingMethod','languages'));
        } catch (Exception $e) {
            return redirect()->route('shipping.root');
        }
    }
    public function updateShippingMethod(ShippingMethodRequest $request,int $shippingMethod_id): RedirectResponse
    {
        $data_request = $request->all();
        if (isset($request->logo))
            $data_request['logo'] = $this->save_file($request->logo, 'shipping_method');

        try {
            $shippingMethod = $this->shippingMethodRepository->updateShippingMethod($data_request);
            if ($shippingMethod)
                return redirect()->route('dashboard.shipping.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
