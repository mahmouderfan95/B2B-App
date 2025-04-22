<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Quotations\UserUpdateStatus;
use App\Http\Requests\Front\SpOrder\SendQuotation;
use App\Services\Front\QuotationServices;
use Illuminate\Http\Request;

class QuotationController extends Controller
{
    public function __construct(public QuotationServices $quotationServices)
    {

    }

    public function store(SendQuotation $request)
    {
        return $this->quotationServices->sendQuotation($request);
    }
    public function VendorSend(Request $request)
    {
        return $this->quotationServices->VendorSend($request);
    }

    public function update(UserUpdateStatus $request)
    {
        return $this->quotationServices->updateQuotationStatus($request);
    }
}
