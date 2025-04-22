<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\CountryRequest;
use App\Models\Country;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Helpers\FileUpload;
class CountryService
{

    use FileUpload;
    private $countryRepository;
    private $languageRepository;

    public function __construct(CountryRepository $countryRepository,LanguageRepository $languageRepository)
    {
        $this->countryRepository = $countryRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Countrys.
     *
     */
    public function getAllCountries($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $countries  = $this->countryRepository->getAllCountries($request);
            return view("admin.countries.index", compact('countries'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Countrys.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.countries.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Country.
     *
     * @return RedirectResponse
     */
    public function storeCountry(CountryRequest $request): RedirectResponse
    {
        $data_request = $request->except('flag');
        if (isset($request->flag))
            $data_request['flag'] = $this->save_file($request->flag,'countries');

        try {
            $country = $this->countryRepository->store($data_request);
            if ($country)
                return redirect()->route('dashboard.countries.index')->with('success', true);
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
            $country = $this->countryRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.countries.edit",compact('country','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.countries.index');
        }
    }

    /**
     * Update Country.
     *
     * @param integer $country_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateCountry(CountryRequest $request,int $country_id): RedirectResponse
    {
        $data_request = $request->except('flag');
        if (isset($request->flag))
            $data_request['flag'] = $this->save_file($request->flag,'countries');

        try {
            $country = $this->countryRepository->update($data_request,$country_id);
            if ($country)
                return redirect()->route('dashboard.countries.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Country.
     *
     * @param int $country_id
     * @return RedirectResponse
     */
    public function deleteCountry(int $country_id): RedirectResponse
    {
        try {
            $country = $this->countryRepository->show($country_id);
            if ($country)
            {
                $this->countryRepository->destroy($country_id);
                return redirect()->route('dashboard.countries.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
