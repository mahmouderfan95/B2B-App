<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\CityResource;
use App\Repositories\Front\CityRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Http\Request;

class CityService
{
    use FileUpload, ApiResponseAble;

    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     *
     * All  Country.
     *
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        try {
            $countries = $this->cityRepository->index($request, $lang);
            $countries = CityResource::collection($countries);

            if (count($countries) > 0) {
                return $this->listResponse($countries);
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
