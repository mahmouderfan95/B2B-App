<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public $transactionService;

    /**
     * Transaction  Constructor.
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }


    /**
     * All Cats
     */
    public function index(Request $request)
    {
        return $this->transactionService->getAllTransactions($request);
    }

    /**
     * create transaction page
     */
    public function create()
    {
    }

    /**
     *  Store Transaction
     */
    public function store(Request $request)
    {

    }

    /**
     * show the transaction
     *
     */
    public function show($id)
    {
        return 'dd';
    }

    /**
     * edit the transaction..
     *
     */
    public function edit(int $id)
    {

    }



    /**
     * Update the transaction
     *
     */
    public function update(Request $request, int $id)
    {
    }

    /**
     *
     * Delete Transaction Using ID.
     *
     */
    public function destroy(int $id)
    {
        return $this->transactionService->deleteTransaction($id);

    }

}
