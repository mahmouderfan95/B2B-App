<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\AttributeGroupRequest;
use App\Models\AttributeGroup;
use App\Repositories\Admin\AttributeGroupRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class AttributeGroupService
{

    use FileUpload;
    private $attributeGroupRepository;
    private $languageRepository;

    public function __construct(AttributeGroupRepository $attributeGroupRepository,LanguageRepository $languageRepository)
    {
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  AttributeGroups.
     *
     */
    public function getAllAttributeGroups($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $attributeGroups  = $this->attributeGroupRepository->getAllAttributeGroups($request);
            return view("admin.attributeGroups.index", compact('attributeGroups'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * create  AttributeGroups.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages  = $this->languageRepository->all();
            return view("admin.attributeGroups.create",compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New AttributeGroup.
     *
     * @return RedirectResponse
     */
    public function storeAttributeGroup(AttributeGroupRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $attributeGroup = $this->attributeGroupRepository->store($data_request);
            if ($attributeGroup)
                return redirect()->route('dashboard.attributeGroups.index')->with('success', true);
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
            $attributeGroup = $this->attributeGroupRepository->show($id);
            $languages  = $this->languageRepository->all();
            return view("admin.attributeGroups.edit",compact('attributeGroup','languages'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.attributeGroups.index');
        }
    }

    /**
     * Update AttributeGroup.
     *
     * @param integer $attributeGroup_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAttributeGroup(AttributeGroupRequest $request,int $attributeGroup_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $attributeGroup = $this->attributeGroupRepository->update($data_request,$attributeGroup_id);
            if ($attributeGroup)
                return redirect()->route('dashboard.attributeGroups.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete AttributeGroup.
     *
     * @param int $attributeGroup_id
     * @return RedirectResponse
     */
    public function deleteAttributeGroup(int $attributeGroup_id): RedirectResponse
    {
        try {
            $attributeGroup = $this->attributeGroupRepository->show($attributeGroup_id);
            if ($attributeGroup)
            {
                $this->attributeGroupRepository->destroy($attributeGroup_id);
                return redirect()->route('dashboard.attributeGroups.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
