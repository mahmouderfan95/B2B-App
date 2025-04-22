<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\UnitRequest;
use App\Models\Unit;
use App\Repositories\Admin\UnitRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class UnitService
{

    use FileUpload;
    private $unitRepository;
    private $languageRepository;

    public function __construct(UnitRepository $unitRepository,LanguageRepository $languageRepository)
    {
        $this->unitRepository = $unitRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Units.
     *
     */
    public function getAllUnits($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $units  = $this->unitRepository->getAllUnits($request);
            return view("admin.units.index", compact('units'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Units.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.units.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Unit.
     *
     * @return RedirectResponse
     */
    public function storeUnit(UnitRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $unit = $this->unitRepository->store($data_request);
            if ($unit)
                return redirect()->route('dashboard.units.index')->with('success', true);
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
            $unit = $this->unitRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.units.edit",compact('unit','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.units.index');
        }
    }

    /**
     * Update Unit.
     *
     * @param integer $unit_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateUnit(UnitRequest $request,int $unit_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $unit = $this->unitRepository->update($data_request,$unit_id);
            if ($unit)
                return redirect()->route('dashboard.units.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Unit.
     *
     * @param int $unit_id
     * @return RedirectResponse
     */
    public function deleteUnit(int $unit_id): RedirectResponse
    {
        try {
            $unit = $this->unitRepository->show($unit_id);
            if ($unit)
            {
                $this->unitRepository->destroy($unit_id);
                return redirect()->route('dashboard.units.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
