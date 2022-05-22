<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Contact\ContactCollection;
use App\Http\Resources\Contact\ContactResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Contact\IContactService;
use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends BaseController
{
    private $contact;

    public function __construct(IContactService $contact)
    {
        $this->middleware('auth:sanctum', ['except' => ['store','exportCsv']]);
        $this->contact = $contact;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() : JsonResponse
    {
        try {
            return $this->handleResponse(new ContactCollection($this->contact->getAllContact()), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving available contact", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        try {
            return $this->handleResponse(new ContactResource($this->contact->createContact($request->validated())), "message sent successfully. we will keep in touch soon", Response::HTTP_CREATED);
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
            return $this->handleResponse(new ContactResource($this->contact->getContactById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving contact with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, $id)
    {
        try {
            return $this->handleResponse(new ContactResource($this->contact->updateContactById($request->validated(), $id)), "Contact details updated successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while updating contact information", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->contact->deleteContactById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    public function exportCsv()
    {
        try {
            return Excel::download(new ContactsExport, 'FixOnTime-contact.xlsx');
        } catch (\Throwable $e) {
            report($e);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
