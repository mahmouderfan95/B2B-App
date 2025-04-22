<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\SettingRequest;
use App\Services\Admin\SettingService;

class SettingController extends Controller
{
    public $settingService;

    /**
     * Setting  Constructor.
     */
    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * show the setting..
     *
     */
    public function show()
    {
        return $this->settingService->show();
    }



    /**
     * Update the setting..
     *
     */
    public function updateSetting(Request $request)
    {
        return $this->settingService->updateSetting($request);
    }

}
