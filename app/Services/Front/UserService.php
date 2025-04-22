<?php

namespace App\Services\Front;

use App\Helpers\FileUpload;
use App\Http\Resources\Front\ClientResource;
use App\Http\Resources\Front\ProductResource;
use App\Mail\ForgetPasswordEmail;
use App\Models\Client;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Front\ProductRepository;
use App\Traits\ApiResponseAble;
use Carbon\Carbon;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Mail;
use App\Mail\VerifyClientEmail;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    use FileUpload, ApiResponseAble;

    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function  register($data)
    {
            $client = Client::create([
                'email'   => $data['email'],
                'password' => Hash::make($data['password']),
                // 'name'    => $data['name'],
                // 'avatar'    => "",
                // 'phone'    => $data['phone']??"",
                // 'another_phone'    => $data['another_phone']??"",
                // 'zip_code'    => $data['zip_code']??"",
            ]);
            // $token =  $this->attemptToLogin($data);
            if ($client){
                $this->sendVerificationMail($client);
                // $userResponse = $this->respondWithToken($token);
                return $this->showResponse([], trans('api.auth.account_created'));
            }
            return $this->errorResponse();

    }

    public function login($data)
    {
        $client = false;
        if(!$client = Client::where('email', $data['email'])->first())
            return $this->ApiErrorResponse( [], trans("api.auth.wrong_data"));


        if (!$token = auth('client')->attempt($data))
           return $this->ApiErrorResponse( [], trans("api.auth.wrong_data"));

        if(! $client->is_email_verified)
            return $this->showResponse(['user' =>new ClientResource($client)], trans("api.auth.inactive_email"));

            if($client->status != 'accepted')
            return $this->showResponse(['user' =>new ClientResource($client)], trans("api.auth.inactive_client"));

        $userResponse = $this->respondWithToken($token);
                return $this->showResponse($userResponse, trans('api.auth.logged_in'));
    }


    public function attemptToLogin(array $data)
    {

        if (!$token = auth('client')->attempt([
            'email'     => $data['email'],
            'password'  => $data['password']
        ])) {
            return false;
        }
        return $token;
    }


    protected function respondWithToken($token, $client=null)
    {
        if($client == null)
            $client = auth('client')->user();
        return  [
            'access_token' => $token,
            'user'         => ClientResource::make($client),
            'token_type'   => 'bearer',
            'expires_in'   => auth('client')->factory()->getTTL() * 60
        ];
    }

    public function forgetPassword( $data)
    {
        $user = Client::where('email', $data['email'])->first();
        if (!$user)
            return $this->successResponse(200,[] ,__('api.auth.account_not_found'));
        $token = Str::random(64);
        $otp = '1234';
        if (env('APP_ENV') === 'production') {
            // if (1) {
                $otp = rand(1000, 9999);
                Mail::to($user->email)->send(new ForgetPasswordEmail($otp));
        }
        DB::table('password_resets')->updateOrInsert(
            ['email' =>  $data['email']],
            [
                'email'      =>  $data['email'],
                'token'      => $token,
                'code'       => $otp,
                'created_at' => Carbon::now()
            ]
        );

        //TODO::send code to email
        return $this->ApiSuccessResponse([
            'token' => $token,
            // 'otp'  => $otp
        ]);
    }


    public function checkOTP($data)
    {
        $correct_tocken = DB::table('password_resets')
            ->where([
                'token' => $data['token'],
                'code'  => $data['code']
            ])->first();
        if($correct_tocken)
            return $this->ApiSuccessResponse([], __("api.auth.account_found"));

            return $this->ApiErrorResponse([],__('api.auth.account_not_found'));
    }

    public function resetPassword($data)
    {
        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $data['token']
            ])->first();

        if (!$updatePassword) {
            return $this->ApiErrorResponse([],__('api.auth.account_not_found'));
        }
        $user = Client::where('email', $updatePassword->email)->first();
        if (!$user)
            return $this->ApiErrorResponse([],__('api.auth.account_not_found'));
        $user->password = Hash::make($data['password']);
        $user->save();

        DB::table('password_resets')->where(['token' => $data['token']])->delete();

        // if (!$token = auth('client')->attempt([
        //     'email'     => $data['email'],
        //     'password'  => $data['password'],
        // ])) {
        //     return $this->errorResponse(Response::HTTP_BAD_REQUEST, [], trans("api.auth.wrong_data"));
        // }
        return $this->ApiSuccessResponse([], __("api.auth.pasword_changed"));
    }

    public function completeProfile($data)
    {
        $currentUser = auth('client')->user();
        $currentUser->update($data);
        return $this->getProfile();
    }


    public function getProfile()
    {
        return $this->successResponse(200, [
            'user' => ClientResource::make(Client::find(auth('client')->id()))
        ]);
    }


    public function sendVerificationMail($client)
    {
        $otp = '1234';


        if (env('APP_ENV') === 'production') {
        // if (1) {
            $otp = rand(1000, 9999);
            Mail::to($client->email)->send(new VerifyClientEmail($otp));
        }
        DB::table('clients_verify')
        ->insert([
            'client_id' => $client->id ,
            'code'      => $otp
        ]);
    }

    public function reSendVerificationMail($data)
    {
        $client = Client::where('email', $data['email'])->first();
        if(!$client || $client->is_email_verified)
            return $this->ApiErrorResponse( [],'');

        DB::table('clients_verify')
            ->where([
                'client_id' => $client->id ,
            ])->delete();

        $this->sendVerificationMail($client);
        return $this->showResponse([], trans('api.auth.verification_main_sent'));

    }

    public function verifyEmail($data)
    {
        $client = Client::where('email', $data['email'])->first();
        if(!$client)
            return $this->ApiErrorResponse( [], trans("api.auth.wrong_verification_code"));

        $verifed = DB::table('clients_verify')
        ->where([
            'client_id' => $client->id ,
            'code'      => $data['otp']
        ])->count();

        if($verifed)
        {
            $client->is_email_verified = 1;
            $client->save();
            DB::table('clients_verify')
            ->where([
                'client_id' => $client->id ,
                'code'      => $data['otp']
            ])->delete();

            $token= JWTAuth::fromUser($client);

            $userResponse = $this->respondWithToken($token, $client);
                return $this->showResponse($userResponse, trans('api.auth.email_verified'));
        }
        else{

            return $this->ApiErrorResponse( [], trans("api.auth.wrong_verification_code"));
        }

    }



}
