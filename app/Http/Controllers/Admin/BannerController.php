<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerRequest;
use App\Services\Admin\BannerService;

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
     * create banner page
     */
    public function create()
    {
        return $this->bannerService->create();
    }

    /**
     *  Store Banner
     */
    public function store(BannerRequest $request)
    {

        return $this->bannerService->storeBanner($request);
    }

    /**
     * show the banner..
     *
     */
    public function show( $id)
    {
        return'dd';
    }

    /**
     * edit the banner..
     *
     */
    public function edit(int $id)
    {
        return $this->bannerService->edit($id);

    }

    /**
     * Update the banner..
     *
     */
    public function update(BannerRequest $request, int $id)
    {
        return $this->bannerService->updateBanner($request,$id);
    }
    /**
     *
     * Delete Banner Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->bannerService->deleteBanner($id);

    }

}
