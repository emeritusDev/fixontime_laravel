<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Subscription\SubscriptionCollection;
use App\Http\Resources\Subscription\SubscriptionResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Subscription\ISubscriptionService;
use App\Http\Requests\Subscription\StoreSubscriptionRequest;
use App\Http\Requests\Subscription\UpdateSubscriptionRequest;

class SubscriptionController extends BaseController
{
    private $subscription;

    public function __construct(ISubscriptionService $subscription)
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
        $this->subscription = $subscription;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        try {
            return $this->handleResponse(new SubscriptionCollection($this->subscription->getAllSubscription()), "", Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while retrieving available subscription", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubscriptionRequest $request)
    {
        try {
            return $this->handleResponse(new SubscriptionResource($this->subscription->createSubscription($request->validated())), "subscription saved successfully", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while creating subscription", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->subscription->deleteSubscriptionById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
