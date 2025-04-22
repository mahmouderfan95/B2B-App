<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Shipping\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public $transaction;
    public $services;
    public function __construct(Transaction $transaction,TransactionService $service)
    {
        $this->transaction = $transaction;
        $this->services = $service;
    }

    public function index()
    {
        return $this->services->getAllTransactions();
    }

    public function destroy($id)
    {
        return $this->services->destroyTransaction($id);
    }
}
