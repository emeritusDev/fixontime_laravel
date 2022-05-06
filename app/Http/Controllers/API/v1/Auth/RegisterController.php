<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\RegisterValidationRequest;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends BaseController
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(RegisterValidationRequest $request)
    {
        $input = $request->validated();
        $user = User::create($input);
        $success['token'] =  $user->createToken($request->email."-FixOnTimeAuthApp")->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->handleResponse($success, 'User successfully registered!');
    }
}
