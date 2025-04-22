<?php

namespace App\Services\Admin;

use App\Helpers\FileUpload;
use App\Repositories\Admin\BankRepository;
use App\Repositories\Admin\CountryRepository;
use App\Repositories\Admin\LanguageRepository;
use App\Repositories\Admin\TransactionRepository;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TransactionService
{

    use FileUpload;

    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     *
     * All  Transactions.
     *
     */
    public function getAllTransactions($request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $transactions = $this->transactionRepository->getAllTransactions($request);
            return view("admin.transactions.index", compact('transactions'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    /**
     * create  Transactions.
     */
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Contracts\Foundation\Application
    {

    }

    /**
     *
     * Create New Transaction.
     *
     * @return RedirectResponse
     */
    public function storeTransaction(TransactionRequest $request): RedirectResponse
    {

    }


    /**
     * edit  transactions
     */
    public function edit($id)
    {

    }


    /**
     * Update Transaction.
     *
     * @param integer $transaction_id
     * @param Request $request
     * @return RedirectResponse
     */

    public function updateTransaction(Request $request, int $transaction_id, $destination = 'dashboard.transactions.index'): RedirectResponse

    {
    }

    /**
     * Delete Transaction.
     *
     * @param int $transaction_id
     * @return RedirectResponse
     */
    public function deleteTransaction(int $transaction_id): RedirectResponse
    {
        try {
            $transaction = $this->transactionRepository->show($transaction_id);
            if ($transaction) {
                $this->transactionRepository->destroy($transaction_id);
                return redirect()->route('dashboard.transactions.index')->with('success', true);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

}
