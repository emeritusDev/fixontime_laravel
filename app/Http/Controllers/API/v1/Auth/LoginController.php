<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\LoginValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(LoginValidationRequest $request)
    {
        error_log($request->email);
        if(Auth::attempt($request->validated())){ 
            $auth = Auth::user(); 
            $success['token'] =  $auth->createToken($request->email."-FixOnTimeAuthApp")->plainTextToken; 
            $success['name'] =  $auth->name;
   
            return $this->handleResponse($success, 'User logged-in!');
        } 

        return $this->handleError('Unauthorised.', ['error'=>'Unauthorised']);
    }
}
