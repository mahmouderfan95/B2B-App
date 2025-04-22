<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Front\LanguageService;
use Illuminate\Http\Request;


class LanguageController extends Controller
{
    public $languageService;

    /**
     * Language  Constructor.
     */
    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->languageService->getAllLanguages($request);
    }

    /**
     * show the language..
     *
     */
    public function show(int $id)
    {
        return $this->languageService->show($id);

    }

}
