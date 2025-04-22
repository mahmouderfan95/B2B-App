<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\Countries\CountryResource;
use App\Repositories\Front\CountryRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Http\Request;

class CountryService
{
    use FileUpload, ApiResponseAble;

    private $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
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
            $countries = $this->countryRepository->index($request, $lang);
            //$countries = CountryResource::collection($countries);

            if (count($countries) > 0) {
                return $this->listResponse(new CountryResource($countries));
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
