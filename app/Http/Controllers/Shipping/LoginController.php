<?php

namespace App\Http\Controllers\Shipping;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('shipping.auth.login');
    }

    public function login( Request $request ): \Illuminate\Http\RedirectResponse
    {

        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::guard('shipping')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('shipping.root');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');

    }

    public function logout( Request $request ): \Illuminate\Http\RedirectResponse
    {
        Auth::guard('shipping')->logout();
        return redirect()->route('shipping.login.form');

    }
}
