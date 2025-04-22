<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\OrderQuotation;
use App\Services\Vendor\QuotationServices;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function __construct(public QuotationServices $quotationServices){}

    public function index()
    {
        return $this->quotationServices->getAllQuotations();
    }

    public function sendReplayPage($id)
    {
        return $this->quotationServices->getSendReplayPage($id);
    }
    public function sendReplay(Request $request,$id)
    {
        return $this->quotationServices->postSendReplay($request,$id);
    }
}
