<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\TypeRequest;
use App\Models\Type;
use App\Repositories\Admin\TypeRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class TypeService
{

    use FileUpload;
    private $typeRepository;
    private $languageRepository;

    public function __construct(TypeRepository $typeRepository,LanguageRepository $languageRepository)
    {
        $this->typeRepository = $typeRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Types.
     *
     */
    public function getAllTypes($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $types  = $this->typeRepository->getAllTypes($request);
            return view("admin.types.index", compact('types'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Types.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.types.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Type.
     *
     * @return RedirectResponse
     */
    public function storeType(TypeRequest $request): RedirectResponse
    {
        $data_request = $request->all();

        try {
            $type = $this->typeRepository->store($data_request);
            if ($type)
                return redirect()->route('dashboard.types.index')->with('success', true);
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
            $type = $this->typeRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.types.edit",compact('type','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.types.index');
        }
    }

    /**
     * Update Type.
     *
     * @param integer $type_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateType(TypeRequest $request,int $type_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $type = $this->typeRepository->update($data_request,$type_id);
            if ($type)
                return redirect()->route('dashboard.types.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Type.
     *
     * @param int $type_id
     * @return RedirectResponse
     */
    public function deleteType(int $type_id): RedirectResponse
    {
        try {
            $type = $this->typeRepository->show($type_id);
            if ($type)
            {
                $this->typeRepository->destroy($type_id);
                return redirect()->route('dashboard.types.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
