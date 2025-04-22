<?php

namespace App\Services\Front;

use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\LanguageResource;
use App\Repositories\Front\LanguageRepository;
use Exception;
use App\Helpers\FileUpload;
use App\Traits\ApiResponseAble;
class LanguageService
{
    use FileUpload, ApiResponseAble;

    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Languages.
     *
     */
    public function getAllLanguages($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages = $this->languageRepository->getAllLanguages($request);
            $languages = LanguageResource::collection($languages);
            if (isset($languages) && count($languages) > 0) {
                return $this->listResponse($languages);
            } else {
                return $this->listResponse([]);
            }
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }

    /**
     * edit  Languages.
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $language =  new LanguageResource($this->languageRepository->show($id));
            if (isset($language))
                return $this->showResponse($language);

            return $this->notFoundResponse();
        } catch (Exception $e) {
            return $this->ApiErrorResponse();
        }
    }
}
