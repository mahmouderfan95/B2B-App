<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\Update;
use App\Services\Admin\ProfileServices;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(public ProfileServices $profileServices)
    {

    }

    public function edit()
    {
        return $this->profileServices->editProfile();
    }

    public function update(Request $request)
    {
        return $this->profileServices->updateProfile($request,auth('web')->user()->id);
    }
}
