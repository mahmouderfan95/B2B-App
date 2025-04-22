<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\LanguageRequest;
use App\Http\Resources\Admin\LanguageResource;
use App\Repositories\Admin\LanguageRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Helpers\FileUpload;
class LanguageService
{
    use FileUpload;
    private $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     *
     * All  Languages.
     *
     */
    public function getAllLanguages($request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $languages = $this->languageRepository->getAllLanguages($request);
            $languages = LanguageResource::collection($languages);
            return view("admin.languages.index", compact('languages'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Languages.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            return view("admin.languages.create");
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * Create New Language.
     *
     * @param LanguageRequest $request
     * @return RedirectResponse
     */
    public function storeLanguage(LanguageRequest $request): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'languages');

        try {
            $language = $this->languageRepository->store($data_request);
            if ($language)
                return redirect()->route('dashboard.languages.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }


    /**
     * edit  Languages.
     */
    public function edit($id): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        try {
            $language = $this->languageRepository->show($id);
            return view("admin.languages.edit",compact('language'));
        } catch (Exception $e) {
            return view("admin.languages.index");
        }
    }
    /**
     * Update Language.
     *
     * @param integer $language_id
     * @param Request $request
     * @return array
     * @throws ValidatorException
     */
    public function updateLanguage(LanguageRequest $request, int $language_id): RedirectResponse
    {
        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->save_file($request->image,'languages');

        try {
            $language = $this->languageRepository->update($data_request,$language_id);
            if ($language)
                return redirect()->route('dashboard.languages.index')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Delete Language.
     *
     * @param int $language_id
     * @return RedirectResponse
     */
    public function deleteLanguage(int $language_id): RedirectResponse
    {
        try {
            $language = $this->languageRepository->show($language_id);
            if ($language)
            {
                $this->remove_file('languages',$language->name);
                $this->languageRepository->destroy($language_id);
                return redirect()->route('dashboard.languages.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }

    }
}
