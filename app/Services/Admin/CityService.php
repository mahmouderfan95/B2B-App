<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\CityRequest;
use App\Repositories\Admin\CityRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\RegionRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CityService
{

    use FileUpload;

    private $cityRepository;
    private $languageRepository;
    private $regionRepository;

    public function __construct(CityRepository $cityRepository, LanguageRepository $languageRepository, RegionRepository $regionRepository)
    {
        $this->cityRepository = $cityRepository;
        $this->languageRepository = $languageRepository;
        $this->regionRepository = $regionRepository;
    }

    /**
     *
     * All  Cities.
     *
     */
    public function getAllCities($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $cities = $this->cityRepository->getAllCities($request);
            return view("admin.cities.index", compact('cities'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Cities.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $regions = $this->regionRepository->getAllRegionsForm();
            $languages = $this->languageRepository->all();
            return view("admin.cities.create", compact('languages', 'regions'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New City.
     *
     * @return RedirectResponse
     */
    public function storeCity(CityRequest $request): RedirectResponse
    {
        $data_request = $request->all();

        try {
            $city = $this->cityRepository->store($data_request);
            if ($city)
                return redirect()->route('dashboard.cities.index')->with('success', true);
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
            $regions = $this->regionRepository->getAllRegionsForm();
            $city = $this->cityRepository->show($id);
            $languages = $this->languageRepository->all();
            return view("admin.cities.edit", compact('city', 'languages', 'regions'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.cities.index');
        }
    }

    /**
     * Update City.
     *
     * @param integer $city_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCity(CityRequest $request, int $city_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $city = $this->cityRepository->update($data_request, $city_id);
            if ($city)
                return redirect()->route('dashboard.cities.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete City.
     *
     * @param int $city_id
     * @return RedirectResponse
     */
    public function deleteCity(int $city_id): RedirectResponse
    {
        try {
            $city = $this->cityRepository->show($city_id);
            if ($city) {
                $this->cityRepository->destroy($city_id);
                return redirect()->route('dashboard.cities.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
