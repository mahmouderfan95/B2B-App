<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\SizeRequest;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\SizeRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SizeService
{

    use FileUpload;
    private $sizeRepository;
    private $languageRepository;

    public function __construct(SizeRepository $sizeRepository,LanguageRepository $languageRepository)
    {
        $this->sizeRepository = $sizeRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Sizes.
     *
     */
    public function getAllSizes($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $sizes  = $this->sizeRepository->getAllSizes($request);
            return view("admin.sizes.index", compact('sizes'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Sizes.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.sizes.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Size.
     *
     * @return RedirectResponse
     */
    public function storeSize(SizeRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $size = $this->sizeRepository->store($data_request);
            if ($size)
                return redirect()->route('dashboard.sizes.index')->with('success', true);
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
            $size = $this->sizeRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.sizes.edit",compact('size','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.sizes.index');
        }
    }

    /**
     * Update Size.
     *
     * @param integer $size_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSize(SizeRequest $request,int $size_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $size = $this->sizeRepository->update($data_request,$size_id);
            if ($size)
                return redirect()->route('dashboard.sizes.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Size.
     *
     * @param int $size_id
     * @return RedirectResponse
     */
    public function deleteSize(int $size_id): RedirectResponse
    {
        try {
            $size = $this->sizeRepository->show($size_id);
            if ($size)
            {
                $this->sizeRepository->destroy($size_id);
                return redirect()->route('dashboard.sizes.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
