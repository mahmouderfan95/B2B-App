<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\BannerRequest;
use App\Models\Banner;
use App\Repositories\Admin\BannerRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Helpers\FileUpload;
class BannerService
{

    use FileUpload;
    private $bannerRepository;
    private $languageRepository;

    public function __construct(BannerRepository $bannerRepository,LanguageRepository $languageRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Banners.
     *
     */
    public function getAllBanners($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $banners  = $this->bannerRepository->getAllBanners($request);
            return view("admin.banners.index", compact('banners'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Banners.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.banners.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Banner.
     *
     * @return RedirectResponse
     */
    public function storeBanner(BannerRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'banners');

        try {
            $banner = $this->bannerRepository->store($data_request);
            if ($banner)
                return redirect()->route('dashboard.banners.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }



    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $banner = $this->bannerRepository->show($id);
            return view("admin.banners.edit",compact('banner'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.banners.index');
        }
    }

    /**
     * Update Banner.
     *
     * @param integer $banner_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBanner(BannerRequest $request,int $banner_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'banners');

        try {
            $banner = $this->bannerRepository->update($data_request,$banner_id);
            if ($banner)
                return redirect()->route('dashboard.banners.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Banner.
     *
     * @param int $banner_id
     * @return RedirectResponse
     */
    public function deleteBanner(int $banner_id): RedirectResponse
    {
        try {
            $banner = $this->bannerRepository->show($banner_id);
            if ($banner)
            {
                $this->bannerRepository->destroy($banner_id);
                return redirect()->route('dashboard.banners.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
