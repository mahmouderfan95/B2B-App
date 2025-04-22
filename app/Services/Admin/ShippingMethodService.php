<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\ShippingMethodRequest;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\ShippingMethodRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShippingMethodService
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
     *
     * All  ShippingMethods.
     *
     */
    public function getAllShippingMethods($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $shippingMethods  = $this->shippingMethodRepository->getAllShippingMethods($request);
            return view("admin.shippingMethods.index", compact('shippingMethods'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  ShippingMethods.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.shippingMethods.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New ShippingMethod.
     *
     * @return RedirectResponse
     */
    public function storeShippingMethod(ShippingMethodRequest $request): RedirectResponse
    {

        $data_request = $request->all();
        if (isset($request->logo))
            $data_request['logo'] = $this->save_file($request->logo, 'shipping_method');


        $data_request['password'] =  Hash::make($request->password);

        try {
            $shippingMethod = $this->shippingMethodRepository->store($data_request);
            if ($shippingMethod)
                return redirect()->route('dashboard.shippingMethods.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }



    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $shippingMethod = $this->shippingMethodRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.shippingMethods.edit",compact('shippingMethod','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.shippingMethods.index');
        }
    }

    /**
     * Update ShippingMethod.
     *
     * @param integer $shippingMethod_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateShippingMethod(ShippingMethodRequest $request,int $shippingMethod_id): RedirectResponse
    {
        $data_request = $request->all();
        if (isset($request->logo))
            $data_request['logo'] = $this->save_file($request->logo, 'shipping_method');

        try {
            $shippingMethod = $this->shippingMethodRepository->update($data_request,$shippingMethod_id);
            if ($shippingMethod)
                return redirect()->route('dashboard.shippingMethods.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
    /**
     * banned  shippingMethodRepository
     */
    public function banned($id)
    {
        try {
            $shippingMethods = $this->shippingMethodRepository->show($id);
            if (isset($shippingMethods))
                $shippingMethod_banned = $this->shippingMethodRepository->banned($id);

            return redirect()->route('dashboard.shippingMethods.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->route('dashboard.shippingMethods.index');
        }
    }

    /**
     * Delete ShippingMethod.
     *
     * @param int $shippingMethod_id
     * @return RedirectResponse
     */
    public function deleteShippingMethod(int $shippingMethod_id): RedirectResponse
    {
        try {
            $shippingMethod = $this->shippingMethodRepository->show($shippingMethod_id);
            if ($shippingMethod)
            {
                $this->shippingMethodRepository->destroy($shippingMethod_id);
                return redirect()->route('dashboard.shippingMethods.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
