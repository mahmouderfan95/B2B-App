<?php

namespace App\Services\Front;

use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Front\AboutUsResource;
use App\Http\Resources\Front\ContactResource;
use App\Http\Resources\Front\FaqResource;
use App\Http\Resources\Front\FastShippingResource;
use App\Http\Resources\Front\HowToNegotiatePricesResource;
use App\Http\Resources\Front\HowToSpecialOrdersResource;
use App\Http\Resources\Front\PrivicyPolicyResource;
use App\Http\Resources\Front\TermsAndConditionResource;
use App\Models\AboutUs;
// use App\Http\Resources\Front\FaqRepository;
// use App\Http\Resources\Front\AboutUsRepository;
// use App\Http\Resources\Front\FaqRepository;
// use App\Http\Resources\Front\FaqRepository;
// use App\Http\Resources\Front\AbouRepository;
use App\Repositories\Front\FaqRepository;
use App\Repositories\Front\AboutUsRepository;
use App\Repositories\Front\ContactInfoRepository;
use App\Repositories\Front\FastShippingRepository;
use App\Repositories\Front\HowToNegotiatePricesRepository;
use App\Repositories\Front\HowToSpecialOrdersRepository;
use App\Repositories\Front\PrivicyPolicyRepository;
use App\Repositories\Front\TermsAndConditionRepository;
use Exception;

use App\Traits\ApiResponseAble;
class SidePageService
{
    use ApiResponseAble;

    private $aboutUsRepository;
    private $contactInfoRepository;
    private $privicyPolicyRepository;
    private $faqRepository;
    private $termsRepository;
    private $fastShippingRepository;
    private $howToSpecialOrdersRepository;
    private $howToNegotiatePriceRepository;
    public function __construct(FaqRepository $faqRepository,
    AboutUsRepository $aboutUsRepository,
    ContactInfoRepository $contactInfoRepository,
    PrivicyPolicyRepository $privicyPolicyRepository,
    TermsAndConditionRepository $termsRepository,
    FastShippingRepository $fastShippingRepository,
    HowToSpecialOrdersRepository $howToSpecialOrdersRepository,
    HowToNegotiatePricesRepository $howToNegotiatePricesRepository,
    )
    {
        $this->aboutUsRepository = $aboutUsRepository;
        $this->contactInfoRepository = $contactInfoRepository;
        $this->privicyPolicyRepository = $privicyPolicyRepository;
        $this->faqRepository = $faqRepository;
        $this->termsRepository = $termsRepository;
        $this->fastShippingRepository = $fastShippingRepository;
        $this->howToSpecialOrdersRepository = $howToSpecialOrdersRepository;
        $this->howToNegotiatePriceRepository = $howToNegotiatePricesRepository;
    }

    /**
     *
     * All  Languages.
     *
     */
    public function getAboutUs($request)    {

        $languages = $this->aboutUsRepository->index($request);
        if (isset($languages) ) {
            $languages = new AboutUsResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }
    public function fastShipping($request)
    {
        $languages = $this->fastShippingRepository->index($request);
        if (isset($languages) ) {
            $languages = new FastShippingResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }
    public function howToSpecialOrders($request)
    {
        $languages = $this->howToSpecialOrdersRepository->index($request);
        if ($languages) {
            $languages = new HowToSpecialOrdersResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }
    public function howToNegotiatePrices($request)
    {
        $languages = $this->howToNegotiatePriceRepository->index($request);
        if ($languages) {
            $languages = new HowToNegotiatePricesResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }

    public function getPrivacyPolicy($request)    {

        $languages = $this->privicyPolicyRepository->index($request);
        if (isset($languages) ) {
            $languages = new PrivicyPolicyResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }

    public function getContactInfo($request)    {

        $languages = $this->contactInfoRepository->index($request);


        if (isset($languages) ) {
            $languages = new ContactResource($languages);
            return $this->listResponse($languages);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }

    public function getFaq($request){

        $faqs = $this->faqRepository->index($request);
        if (isset($faqs) && count($faqs) > 0) {
            $faqs = FaqResource::collection($faqs);
            return $this->listResponse($faqs);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }

    public function getTerms($request){

        $terms = $this->termsRepository->index($request);
        if ($terms) {
            $terms = new TermsAndConditionResource($terms);
            return $this->listResponse($terms);
        } else {
            return setResponseApi(false,400,'data not found',[]);
        }
    }


}
