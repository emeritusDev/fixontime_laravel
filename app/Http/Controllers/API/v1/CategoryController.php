<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Category\ICategoryService;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends BaseController
{
    private $category;

    public function __construct(ICategoryService $category)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        try {
            return $this->handleResponse(new CategoryCollection($this->category->getAllCategory()), "", Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while retrieving available category", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            return $this->handleResponse(new CategoryResource($this->category->createCategory($request->validated())), "category saved successfully", Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while creating category", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            return $this->handleResponse(new CategoryResource($this->category->getCategoryById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while retriving category with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            return $this->handleResponse(new CategoryResource($this->category->updateCategoryById($request->validated(), $id)), "Category details updated successfully", Response::HTTP_OK);
        } catch (\Throwable $th) {
            report($e);
            return $this->handleError("An error occur while updating category information", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->category->deleteCategoryById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
