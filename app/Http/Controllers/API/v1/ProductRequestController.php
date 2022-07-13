<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ProductRequest\ProductRequestCollection;
use App\Http\Resources\ProductRequest\ProductRequestResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\ProductRequest\IProductRequestService;
use App\Http\Requests\ProductRequest\StoreProductEnquiryRequest;
use App\Exports\ProductRequestsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductRequestController extends BaseController
{
    private $productRequest;

    public function __construct(IProductRequestService $productRequest)
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
        $this->productRequest = $productRequest;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        try {
            return $this->handleResponse(new ProductRequestCollection($this->productRequest->getAllProductRequest()), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving available productRequest", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductEnquiryRequest $request)
    {
        try {
            return $this->handleResponse(new ProductRequestResource($this->productRequest->createProductRequest($request->validated())), "message sent successfully. we will keep in touch soon", Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error while sending your message", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            return $this->handleResponse(new ProductRequestResource($this->productRequest->getProductRequestById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving productRequest with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->productRequest->deleteProductRequestById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function exportCsv()
    {
        try {
            return Excel::download(new ProductRequestsExport, 'FixOnTime-productRequest.xlsx');
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
