<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\AllShippingMethodResource;
use App\Http\Resources\Front\ShippingMethodResource;
use App\Models\ShippingMethod;
use App\Repositories\Front\ShippingMethodRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Http\Request;

class ShippingMethodService
{
    use FileUpload, ApiResponseAble;

    private $shippingMethodRepository;

    public function __construct(ShippingMethodRepository $shippingMethodRepository)
    {
        $this->shippingMethodRepository = $shippingMethodRepository;
    }

    /**
     *
     * All  Categories.
     *
     */
    public function getAllShippingMethods(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        $shippingMethods = $this->shippingMethodRepository->getAllShippingMethods($lang);
        try {
            if (isset($shippingMethods) && count($shippingMethods) > 0) {
                return setResponseApi(true,200,'success message',AllShippingMethodResource::collection($shippingMethods));
            } else {
                return setResponseApi(false,400,'data not found',[]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     *
     *      details.
     *
     */
    public function details(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

        $shippingMethods = $this->shippingMethodRepository->details($request, $lang, $id);

        if (isset($shippingMethods) && count($shippingMethods) > 0) {
            $shippingMethods = new ShippingMethodResource($shippingMethods->first());
            return setResponseApi(true,200,'success message',$shippingMethods);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }

    }    /**
     *
     *      details.
     *
     */
    public function offer(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

        $shippingMethods = $this->shippingMethodRepository->offer($request, $lang, $id);

        if (count($shippingMethods) > 0) {
            return $this->listResponse($shippingMethods);
        } else {
            return $this->listResponse([]);
        }

    }
    public function special_offer(Request $request, $id): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);

        $shippingMethods = $this->shippingMethodRepository->special_offer($request, $lang, $id);

        if (count($shippingMethods) > 0) {
            return $this->listResponse($shippingMethods);
        } else {
            return $this->listResponse([]);
        }

    }

}
