<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\QualityResource;
use App\Repositories\Front\QualityRepository;
use App\Traits\ApiResponseAble;

class QualityService
{
    use FileUpload, ApiResponseAble;

    private $qualityRepository;

    public function __construct(QualityRepository $qualityRepository)
    {
        $this->qualityRepository = $qualityRepository;
    }

    /**
     *
     * All  Languages.
     *
     */
    public function getAllQualities($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {

        $languages = $this->qualityRepository->getAllLanguages($request);
        // $languages = QualityResource::collection($languages);
        if (isset($languages) && count($languages) > 0) {
            return $this->listResponse($languages);
        } else {
            return $this->listResponse([]);
        }
    }

    /**
     * edit  Languages.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {

        $quality = $this->qualityRepository->show($id);
        if (isset($quality))
            return $this->showResponse(new QualityResource($quality));

        return $this->notFoundResponse();
    }
}
