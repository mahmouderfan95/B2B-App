<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Models\Setting;
use App\Repositories\Admin\SettingRepository;
use App\Repositories\Admin\LanguageRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Exception;
use App\Helpers\FileUpload;
class SettingService
{

    use FileUpload;
    private $settingRepository;
    private $languageRepository;

    public function __construct(SettingRepository $settingRepository,LanguageRepository $languageRepository)
    {
        $this->settingRepository = $settingRepository;
        $this->languageRepository = $languageRepository;
    }
    /**
     * show  Settings.
     */
    public function show(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $setting = $this->settingRepository->show();
            return view("admin.settings.create",compact('setting'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }

    /**
     * Update Setting.
     *
     * @param integer $setting_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSetting(Request $request): RedirectResponse
    {
        $data_request = $request->except(['config_setting_logo','_token']);
        if (isset($request->config_setting_logo))
            $data_request['config_setting_logo'] = $this->save_file($request->config_setting_logo,'settings');
        try {
            $setting = $this->settingRepository->updateSetting($data_request);
            if ($setting)
                return redirect()->route('dashboard.settings.shoe')->with('success', true);
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error','message' => __('admin.general_error')]);
        }
    }
}
