<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\AboutUsRequest;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\AboutUsRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AboutUsService
{

    use FileUpload;
    private $aboutUsRepository;
    private $languageRepository;

    public function __construct(AboutUsRepository $aboutUsRepository,LanguageRepository $languageRepository)
    {
        $this->aboutUsRepository = $aboutUsRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  AboutUss.
     *
     */
    public function getAllAboutUss($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $aboutUss  = $this->aboutUsRepository->getAllAboutUss($request);
            return view("admin.aboutUss.index", compact('aboutUss'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  AboutUss.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.aboutUss.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New AboutUs.
     *
     * @return RedirectResponse
     */
    public function storeAboutUs(AboutUsRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $aboutUs = $this->aboutUsRepository->store($data_request);
            if ($aboutUs)
                return redirect()->route('dashboard.aboutUss.index')->with('success', true);
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
            $aboutUs = $this->aboutUsRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.aboutUss.edit",compact('aboutUs','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.aboutUss.index');
        }
    }

    /**
     * Update AboutUs.
     *
     * @param integer $aboutUs_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAboutUs(AboutUsRequest $request,int $aboutUs_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $aboutUs = $this->aboutUsRepository->update($data_request,$aboutUs_id);
            if ($aboutUs)
                return redirect()->route('dashboard.aboutUss.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete AboutUs.
     *
     * @param int $aboutUs_id
     * @return RedirectResponse
     */
    public function deleteAboutUs(int $aboutUs_id): RedirectResponse
    {
        try {
            $aboutUs = $this->aboutUsRepository->show($aboutUs_id);
            if ($aboutUs)
            {
                $this->aboutUsRepository->destroy($aboutUs_id);
                return redirect()->route('dashboard.aboutUss.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
