<?php
namespace App\Services\Shipping;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionService{
    public function getAllTransactions()
    {
        try {
            $transactions = Transaction::get();
            return view("shipping.transactions.index", compact('transactions'));
        } catch (Exception $e) {
            return response()->json(['status' => 'general_error', 'message' => __('admin.general_error')]);
        }
    }

    private function getTransactionById($id)
    {
        $transaction = Transaction::find($id);
        if($transaction) return $transaction;
    }

    public function destroyTransaction($id)
    {
        $transaction = $this->getTransactionById($id);
        if($transaction){
            $transaction->delete();
            return redirect()->back();
        }
    }
}
