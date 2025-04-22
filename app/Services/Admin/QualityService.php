<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\QualityRequest;
use App\Models\Quality;
use App\Repositories\Admin\QualityRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class QualityService
{

    use FileUpload;
    private $qualityRepository;
    private $languageRepository;

    public function __construct(QualityRepository $qualityRepository,LanguageRepository $languageRepository)
    {
        $this->qualityRepository = $qualityRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Qualitys.
     *
     */
    public function getAllQualitys($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $qualities  = $this->qualityRepository->getAllQualitys($request);
            return view("admin.qualities.index", compact('qualities'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Qualitys.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.qualities.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Quality.
     *
     * @return RedirectResponse
     */
    public function storeQuality(QualityRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $quality = $this->qualityRepository->store($data_request);
            if ($quality)
                return redirect()->route('dashboard.qualities.index')->with('success', true);
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
            $quality = $this->qualityRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.qualities.edit",compact('quality','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.qualities.index');
        }
    }

    /**
     * Update Quality.
     *
     * @param integer $quality_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateQuality(QualityRequest $request,int $quality_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $quality = $this->qualityRepository->update($data_request,$quality_id);
            if ($quality)
                return redirect()->route('dashboard.qualities.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Quality.
     *
     * @param int $quality_id
     * @return RedirectResponse
     */
    public function deleteQuality(int $quality_id): RedirectResponse
    {
        try {
            $quality = $this->qualityRepository->show($quality_id);
            if ($quality)
            {
                $this->qualityRepository->destroy($quality_id);
                return redirect()->route('dashboard.qualities.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
