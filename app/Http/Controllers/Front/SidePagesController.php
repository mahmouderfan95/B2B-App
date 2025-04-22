<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\SidePageService;
use Illuminate\Http\Request;


class SidePagesController extends Controller
{
    public $SidePagesService;

    /**
     * Language  Constructor.
     */
    public function __construct(SidePageService $SidePagesService)
    {
        $this->SidePagesService = $SidePagesService;
    }


    public function aboutUs(Request $request)
    {
        return $this->SidePagesService->getAboutUs($request);
    }
    public function fastShipping(Request $request)
    {
        return $this->SidePagesService->fastShipping($request);
    }
    public function howToSpecialOrders(Request $request)
    {
        return $this->SidePagesService->howToSpecialOrders($request);
    }
    public function howToNegotiatePrices(Request $request)
    {
        return $this->SidePagesService->howToNegotiatePrices($request);
    }
    public function contactInfo(Request $request)
    {
        return $this->SidePagesService->getContactInfo($request);
    }

    /**
     * All Faq
     */
    public function privacyPolicy(Request $request)
    {
        return $this->SidePagesService->getPrivacyPolicy($request);
    }

    public function faq(Request $request)
    {
        return $this->SidePagesService->getFaq($request);
    }

    public function tersmAnsConditions(Request $request)
    {
        return $this->SidePagesService->getTerms($request);
    }




}
