<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ContactUs\SendMessage;
use App\Services\Front\ContactUsServices;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct(public ContactUsServices $contactUsServices)
    {

    }

    public function store(SendMessage $request)
    {
        return $this->contactUsServices->sendContactMessage($request);
    }
}
