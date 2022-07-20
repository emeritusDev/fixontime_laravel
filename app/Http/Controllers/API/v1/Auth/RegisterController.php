<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\RegisterValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class RegisterController extends BaseController
{
    public function index(RegisterValidationRequest $request)
    {
        try {
            $input = $request->validated();
            $user = User::create($input);
       
            return $this->handleResponse([], 'Admin created successfully!');
        } catch (\Throwable $th) {
            return $this->handleError("An error occur while submitting data. please try again", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
