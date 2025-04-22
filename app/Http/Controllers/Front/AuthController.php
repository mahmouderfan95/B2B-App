<?php

namespace App\Http\Controllers\Front;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Auth\CompleteProfileRequest;
use App\Http\Requests\Front\Auth\LoginRequest;
use App\Http\Requests\Front\Auth\RegisterRequest;
use App\Http\Requests\Front\Auth\VerifyEmailRequest;
use App\Http\Resources\Front\ClientResource;
use App\Models\User;
use App\Services\Front\UserService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public $userService;
    public function __construct(UserService $userService)
    {
        $this->middleware('auth:client', ['only' => ['logout','refresh','me','completeProfile']]);
        $this->userService = $userService;


    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        return $this->userService->register($data);
    }

    public function verifyEmail(VerifyEmailRequest $request)
    {
        return $this->userService->verifyEmail($request->all());
    }

    public function reSendVerificationMail(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email',"exists:clients,email"],
        ]);
        return $this->userService->reSendVerificationMail($data);
    }


    public function login(LoginRequest $request)
    {
        return $this->userService->login(
            $request->validated()
        );
    }

    public function checkOTP(Request $request)
    {
        $data = $request->validate([
            'code'     => ['required'],
            'token'    => ['required']
        ]);

        return $this->userService->checkOTP($data);
    }

    public function forgetPassword(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required', 'email',"exists:clients,email"],
        ]);

        return $this->userService->forgetPassword($data);
    }

    public function completeProfile(CompleteProfileRequest $request)
    {
        return $this->userService->completeProfile($request->validated());
    }

    public function resetPassword(Request $request)
    {

        $data = $request->validate([

            'password'        => ['required', 'string', 'confirmed', 'min:6', 'max:32'],
            'token'           => ['required']
        ]);
        return $this->userService->resetPassword($data);

    }

    public function me()
    {
       return $this->userService->getProfile();
    }

    public function logout()
    {
        auth('client')->logout();
        return response()->json(['message' => __('api.auth.logged_out_successfully')]);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth('client')->refresh());
    }

    protected function respondWithToken($token)
    {
        return $this->successResponse(null, [
            'access_token' => $token,
            'user'         => ClientResource::make(auth('client')->user()),
            'token_type'   => 'bearer',
            'expires_in'   => auth('client')->factory()->getTTL() * 60
        ]);
    }
}
