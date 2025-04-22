<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\SettingService;
use Illuminate\Http\Request;


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
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->settingService->getAllSettings($request);
    }


    public function details($key)
    {
        return $this->settingService->details($key);
    }

}
