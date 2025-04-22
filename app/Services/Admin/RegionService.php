<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\RegionRequest;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\RegionRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegionService
{

    use FileUpload;

    private $regionRepository;
    private $languageRepository;
    private $countryRepository;

    public function __construct(RegionRepository $regionRepository, LanguageRepository $languageRepository, CountryRepository $countryRepository)
    {
        $this->regionRepository = $regionRepository;
        $this->languageRepository = $languageRepository;
        $this->countryRepository = $countryRepository;
    }

    /**
     *
     * All  Regions.
     *
     */
    public function getAllRegions($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $regions = $this->regionRepository->getAllRegions($request);
            return view("admin.regions.index", compact('regions'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Regions.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $countries = $this->countryRepository->getAllCountriesForm();
            $languages = $this->languageRepository->all();
            return view("admin.regions.create", compact('languages','countries'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Region.
     *
     * @return RedirectResponse
     */
    public function storeRegion(RegionRequest $request): RedirectResponse
    {
        $data_request = $request->all();

        try {
            $region = $this->regionRepository->store($data_request);
            if ($region)
                return redirect()->route('dashboard.regions.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  Languages.
     */
    public function edit($id)
    {
        try {
            $countries = $this->countryRepository->getAllCountriesForm();
            $region = $this->regionRepository->show($id);
            $languages = $this->languageRepository->all();
            return view("admin.regions.edit", compact('region', 'languages', 'countries'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.regions.index');
        }
    }

    /**
     * Update Region.
     *
     * @param integer $region_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateRegion(RegionRequest $request, int $region_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $region = $this->regionRepository->update($data_request, $region_id);
            if ($region)
                return redirect()->route('dashboard.regions.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Region.
     *
     * @param int $region_id
     * @return RedirectResponse
     */
    public function deleteRegion(int $region_id): RedirectResponse
    {
        try {
            $region = $this->regionRepository->show($region_id);
            if ($region) {
                $this->regionRepository->destroy($region_id);
                return redirect()->route('dashboard.regions.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
