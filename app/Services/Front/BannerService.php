<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\BannerResource;
use App\Repositories\Front\BannerRepository;
use App\Traits\ApiResponseAble;
use Exception;

class BannerService
{
    use FileUpload, ApiResponseAble;

    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     *
     * All  Banners.
     *
     */
    public function getAllBanners($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $banners = $this->bannerRepository->getAllBanners($request);
            $banners = BannerResource::collection($banners);
            if (isset($banners) && count($banners) > 0) {
                return setResponseApi(true,200,'success message',$banners);
            } else {
                return setResponseApi(false,400,'data not found',[]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     * edit  Banners.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $banner = new BannerResource($this->bannerRepository->show($id));
            if (isset($banner))
                return $this->showResponse($banner);

            return $this->notFoundResponse();
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
