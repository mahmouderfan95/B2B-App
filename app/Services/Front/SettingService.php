<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\SettingResource;
use App\Repositories\Front\SettingRepository;
use App\Traits\ApiResponseAble;
use Exception;

class SettingService
{
    use FileUpload, ApiResponseAble;

    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     *
     * All  Settings.
     *
     */
    public function getAllSettings($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {

        $settings = $this->settingRepository->getAllSettings($request);
        $settings = SettingResource::collection($settings);
        if (isset($settings) && count($settings) > 0) {
            return setResponseApi(true,200,'success message',$settings);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }

    }

    public function details($key): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {


        try {
            $setting = $this->settingRepository->details($key);
            $setting = new SettingResource($setting);
            if ($setting)
                return $this->listResponse($setting);


            return $this->listResponse([]);

        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
