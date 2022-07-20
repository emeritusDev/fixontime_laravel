<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\Auth\RegisterValidationRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class AdminController extends BaseController
{
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('auth:sanctum');
        $this->user = $user;
    }

    public function index(Request $request) 
    {
        $paginateValue = $request->query('paginate');
        try {
            return $this->user->all();
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving available admins", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function store(RegisterValidationRequest $request)
    {
        try {
            $input = $request->validated();
            $user = $this->user->create($input);
       
            return $this->handleResponse([], 'Admin created successfully!');
        } catch (\Throwable $th) {
            return $this->handleError("An error occur while submitting data. please try again", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
