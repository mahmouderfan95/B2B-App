<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('vendor.auth.login');
    }

    public function login( Request $request ) {

        $credentials = $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('vendor.root');
        }
        elseif (Auth::guard('sub_vendor')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('sub-vendor.root');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function logout( Request $request ) {
        Auth::guard('vendor')->logout();
        return redirect()->route('vendor.login.form');

    }
}
