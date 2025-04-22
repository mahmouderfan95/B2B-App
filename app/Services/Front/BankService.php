<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\Bancks\BankResource as BancksBankResource;
use App\Http\Resources\Front\BankResource;
use App\Repositories\Front\BankRepository;
use App\Traits\ApiResponseAble;
use Exception;
use Illuminate\Http\Request;

class BankService
{
    use FileUpload, ApiResponseAble;

    private $bankRepository;

    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     *
     * All  Banks.
     *
     */
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
        try {
            $banks = $this->bankRepository->index($request, $lang);
            if (count($banks) > 0) {
                return setResponseApi(true,200,'success message',new BancksBankResource($banks));
            } else {
                return setResponseApi(false,400,'data not found',[]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
