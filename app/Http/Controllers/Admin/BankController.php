<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankRequest;
use App\Services\Admin\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public $bankService;

    /**
     * Bank  Constructor.
     */
    public function __construct(BankService $bankService)
    {
        $this->bankService = $bankService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->bankService->getAllBanks($request);
    }

    /**
     * create bank page
     */
    public function create()
    {
        return $this->bankService->create();
    }

    /**
     *  Store Bank
     */
    public function store(BankRequest $request)
    {

        return $this->bankService->storeBank($request);
    }

    /**
     * show the bank..
     *
     */
    public function show( $id)
    {
        return'dd';
    }

    /**
     * edit the bank..
     *
     */
    public function edit(int $id)
    {
        return $this->bankService->edit($id);

    }

    /**
     * Update the bank..
     *
     */
    public function update(BankRequest $request, int $id)
    {
        return $this->bankService->updateBank($request,$id);
    }
    /**
     *
     * Delete Bank Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->bankService->deleteBank($id);

    }

}
