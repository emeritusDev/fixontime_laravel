<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\ForgotPasswordValidationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use App\Events\ResetPasswordProcessed as ResetPasswordEvent;
use App\Mail\ResetPasswordTemplate;

class ForgotPasswordController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ForgotPasswordValidationRequest $request)
    {
        try {
            $userEmail = $request->validated()['email'];
            $token = Str::random(64);
            DB::table('password_resets')->insert([
                'email' => $userEmail, 
                'token' => $token, 
                'created_at' => Carbon::now()
            ]);
            event(new ResetPasswordEvent($userEmail, $token));
            \Mail::to($userEmail)
                ->send(new ResetPasswordTemplate($token, $userEmail));
            return $this->handleResponse([], 'We have e-mailed your password reset link!');
        } catch (\Throwable $th) {
            return $th;
            return $this->handleError('Unauthorised.', ['error'=>'An error occured. Please try again!']);
        }
    }
}
