<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\ResetPasswordValidationRequest;
use DB; 
use Carbon\Carbon; 
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends BaseController
{
    public function index(ResetPasswordValidationRequest $request, User $user)
    {
        try {
            $data = $request->validated();
            $validToken = DB::table('password_resets')->where([
                'email' => $data['email'], 'token' => $data['token']
            ])->first();
            if ($validToken) {
                $user->where('email', $data['email'])->update(['password' => Hash::make($data['password'])]);
                DB::table('password_resets')->where(['email'=> $data['email']])->delete();
            }
            return $this->handleResponse([], 'Your password has been changed!');
        } catch (\Throwable $th) {
            return $this->handleError('Unauthorised.', ['error'=>'An error occured. Please try again!']);
        }
    }
}
