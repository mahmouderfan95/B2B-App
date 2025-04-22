<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\BannerService;
use Illuminate\Http\Request;


class BannerController extends Controller
{
    public $bannerService;

    /**
     * Banner  Constructor.
     */
    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->bannerService->getAllBanners($request);
    }

    /**
     * show the banner..
     *
     */
    public function show(int $id)
    {
        return $this->bannerService->show($id);

    }

}
