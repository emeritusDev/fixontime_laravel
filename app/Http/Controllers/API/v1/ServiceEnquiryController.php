<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\ServiceEnquiry\ServiceEnquiryCollection;
use App\Http\Resources\ServiceEnquiry\ServiceEnquiryResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Enquiry\IEnquiryService;
use App\Http\Requests\Enquiry\StoreServiceEnquiryRequest;
use App\Http\Requests\Enquiry\UpdateServiceEnquiryRequest;
use App\Exports\ServiceEnquirysExport;
use Maatwebsite\Excel\Facades\Excel;

class ServiceEnquiryController extends BaseController
{
    private $serviceEnquiry;

    public function __construct(IEnquiryService $serviceEnquiry)
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
        $this->serviceEnquiry = $serviceEnquiry;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        try {
            return $this->handleResponse(new ServiceEnquiryCollection($this->serviceEnquiry->getAllEnquiry()), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while retrieving available Enquiries", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceEnquiryRequest $request)
    {
        try {
            return $this->handleResponse(new ServiceEnquiryResource($this->serviceEnquiry->createEnquiry($request->validated())), "message sent successfully. we will keep in touch soon", Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            report($err);
            return $err;
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
            return $this->handleResponse(new ServiceEnquiryResource($this->serviceEnquiry->getEnquiryById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving serviceEnquiry with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceEnquiryRequest $request, $id)
    {
        try {
            return $this->handleResponse(new ServiceEnquiryResource($this->serviceEnquiry->updateEnquiryById($request->validated(), $id)), "ServiceEnquiry details updated successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while updating serviceEnquiry information", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->serviceEnquiry->deleteEnquiryById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function exportCsv()
    {
        try {
            return Excel::download(new ServiceEnquirysExport, 'FixOnTime-serviceEnquiry.xlsx');
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
