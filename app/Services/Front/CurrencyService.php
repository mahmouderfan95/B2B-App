<?php

namespace App\Services\Front;

use App\Http\Requests\Admin\CurrencyRequest;
use App\Http\Resources\Front\CurrencyResource;
use App\Repositories\Front\CurrencyRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Traits\ApiResponseAble;
class CurrencyService
{
    use FileUpload, ApiResponseAble;

    private $currencyRepository;

    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     *
     * All  Currencys.
     *
     */
    public function getAllCurrencies($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $currencies = $this->currencyRepository->getAllCurrencies($request);
            $currencies = CurrencyResource::collection($currencies);
            if (isset($currencies) && count($currencies) > 0) {
                return $this->listResponse($currencies);
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     * edit  Currencys.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $currency = new CurrencyResource($this->currencyRepository->show($id));
            if (isset($currency))
                return $this->showResponse($currency);

            return $this->notFoundResponse();
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
