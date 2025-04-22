<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Http\Requests\Admin\AttributeRequest;
use App\Repositories\Admin\AttributeGroupRepository;
use App\Repositories\Admin\AttributeRepository;
use App\Repositories\Admin\LanguageRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttributeService
{

    use FileUpload;

    private $attributeGroupRepository;
    private $attributeRepository;
    private $languageRepository;

    public function __construct(AttributeRepository $attributeRepository, AttributeGroupRepository $attributeGroupRepository, LanguageRepository $languageRepository)
    {
        $this->attributeRepository = $attributeRepository;
        $this->attributeGroupRepository = $attributeGroupRepository;
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Attributes.
     *
     */
    public function getAllAttributes($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $attributes = $this->attributeRepository->getAllAttributes($request);
            return view("admin.attributes.index", compact('attributes'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Attributes.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $attributeGroups = $this->attributeGroupRepository->getAllAttributeGroupsForm();
            $languages = $this->languageRepository->all();

            return view("admin.attributes.create", compact('languages', 'attributeGroups'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     *
     * Create New Attribute.
     *
     * @return RedirectResponse
     */
    public function storeAttribute(AttributeRequest $request): RedirectResponse
    {

        $data_request = $request->all();

        try {
            $attribute = $this->attributeRepository->store($data_request);
            if ($attribute)
                return redirect()->route('dashboard.attributes.index')->with('success', true);
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
            $attribute = $this->attributeRepository->show($id);
            $attributeGroups = $this->attributeGroupRepository->getAllAttributeGroupsForm();
            $languages = $this->languageRepository->all();
            return view("admin.attributes.edit", compact('attribute', 'languages', 'attributeGroups'));
        } catch (Exception $e) {
            return redirect()->route('dashboard.attributes.index');
        }
    }

    /**
     * Update Attribute.
     *
     * @param integer $attribute_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateAttribute(AttributeRequest $request, int $attribute_id): RedirectResponse
    {
        $data_request = $request->all();
        try {
            $attribute = $this->attributeRepository->update($data_request, $attribute_id);
            if ($attribute)
                return redirect()->route('dashboard.attributes.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Attribute.
     *
     * @param int $attribute_id
     * @return RedirectResponse
     */
    public function deleteAttribute(int $attribute_id): RedirectResponse
    {
        try {
            $attribute = $this->attributeRepository->show($attribute_id);
            if ($attribute) {
                $this->attributeRepository->destroy($attribute_id);
                return redirect()->route('dashboard.attributes.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }
}
