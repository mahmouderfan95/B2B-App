<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Services\Admin\LanguageService;
use Illuminate\Http\Request;
use Prettus\Validator\Exceptions\ValidatorException;


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
     * create language page
     */
    public function create()
    {
        return $this->languageService->create();
    }

    /**
     *  Store Language
     */
    public function store(LanguageRequest $request)
    {

        return $this->languageService->storeLanguage($request);
    }

    /**
     * show the language..
     *
     */
    public function show(int $id)
    {
    }

    /**
     * edit the language..
     *
     */
    public function edit(int $id)
    {
        return $this->languageService->edit($id);

    }

    /**
     * Update the language..
     *
     * @throws ValidatorException
     */
    public function update(LanguageRequest $request, int $id)
    {
        return $this->languageService->updateLanguage($request, $id);
    }

    /**
     *
     * Delete Language Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->languageService->deleteLanguage($id);

    }

}
