<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\RegisterValidationRequest;
use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends BaseController
{
    public function index(RegisterValidationRequest $request)
    {
        $input = $request->validated();
        $user = User::create($input);
        $success['token'] =  $user->createToken($request->email."-FixOnTimeAuthApp")->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->handleResponse($success, 'User successfully registered!');
    }
}
