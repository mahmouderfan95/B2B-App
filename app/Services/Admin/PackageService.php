<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\PackageRequest;
use App\Models\Package;
use App\Repositories\Admin\PackageRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class PackageService
{

    use FileUpload;
    private $packageRepository;
    private $languageRepository;

    public function __construct(PackageRepository $packageRepository,LanguageRepository $languageRepository)
    {
        $this->packageRepository = $packageRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Packages.
     *
     */
    public function getAllPackages($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $packages  = $this->packageRepository->getAllPackages($request);
            return view("admin.packages.index", compact('packages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Packages.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.packages.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Package.
     *
     * @return RedirectResponse
     */
    public function storePackage(PackageRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $package = $this->packageRepository->store($data_request);
            if ($package)
                return redirect()->route('dashboard.packages.index')->with('success', true);
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
            $package = $this->packageRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.packages.edit",compact('package','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.packages.index');
        }
    }

    /**
     * Update Package.
     *
     * @param integer $package_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePackage(PackageRequest $request,int $package_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $package = $this->packageRepository->update($data_request,$package_id);
            if ($package)
                return redirect()->route('dashboard.packages.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Package.
     *
     * @param int $package_id
     * @return RedirectResponse
     */
    public function deletePackage(int $package_id): RedirectResponse
    {
        try {
            $package = $this->packageRepository->show($package_id);
            if ($package)
            {
                $this->packageRepository->destroy($package_id);
                return redirect()->route('dashboard.packages.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
