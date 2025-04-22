<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\QualityService;
use Illuminate\Http\Request;


class QualityController extends Controller
{
    public $qualityService;

    /**
     * Language  Constructor.
     */
    public function __construct(QualityService $languageService)
    {
        $this->qualityService = $languageService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->qualityService->getAllQualities($request);
    }

    /**
     * show the language..
     *
     */
    public function show(int $id)
    {
        return $this->qualityService->show($id);

    }

}
