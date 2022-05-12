<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Learning\LearningCollection;
use App\Http\Resources\Learning\LearningResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Learning\ILearningService;
use App\Http\Requests\Learning\StoreLearningRequest;
use App\Http\Requests\Learning\UpdateLearningRequest;

class LearningController extends BaseController
{
    private ILearningService $learning;

    public function __construct(ILearningService $learning)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->learning = $learning;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        try {
            return $this->handleResponse(new LearningCollection($this->learning->getAllLearning()), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving available learning", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLearningRequest $request)
    {
        try {
            return $this->handleResponse(new LearningResource($this->learning->createLearning($request->validated())), "learning saved successfully", Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while creating learning", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->handleResponse(new LearningResource($this->learning->getLearningById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retriving learning with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLearningRequest $request, $id)
    {
        try {
            return $this->handleResponse(new LearningResource($this->learning->updateLearningById($request->validated(), $id)), "Learning details updated successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while updating learning information", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->learning->deleteLearningById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError($err->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
