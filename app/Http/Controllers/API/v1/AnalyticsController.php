<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Services\Subscription\ISubscriptionService;
use App\Services\Post\IPostService;
use App\Services\Learning\ILearningService;
use App\Services\Contact\IContactService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Contact\ContactCollection;
use App\Http\Resources\ProductRequest\ProductRequestCollection;
use App\Http\Resources\ServiceEnquiry\ServiceEnquiryCollection;
use App\Services\ProductRequest\IProductRequestService;
use App\Services\Enquiry\IEnquiryService;

class AnalyticsController extends BaseController
{
    private IPostService $post;
    private ISubscriptionService $subscription;
    private IContactService $contact;
    private ILearningService $learning;
    private IProductRequestService $productRequest;
    private IEnquiryService $serviceEnquiry;

    public function __construct(
        IPostService $post,
        ISubscriptionService $subscription,
        IContactService $contact,
        ILearningService $learning,
        IProductRequestService $productRequest,
        IEnquiryService $serviceEnquiry
    )
    {
        // $this->middleware('auth:sanctum');
        $this->post = $post;
        $this->subscription = $subscription;
        $this->contact = $contact;
        $this->learning = $learning;
        $this->productRequest = $productRequest;
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
            $noOfPost = $this->post->getAllPostCount();
            $noOfSubscriber = $this->subscription->getAllSubscriptionCount();
            $noOfLearning = $this->learning->getAllLearningCount();
            $noOfContact = $this->contact->getNewContactCount();
            $newContact = $this->contact->getNewContact();
            $noOfEnquiry = $this->serviceEnquiry->getNewEnquiryCount();
            $newEnquiry = $this->serviceEnquiry->getNewEnquiry();
            $noOfProducRequest = $this->productRequest->getNewProductRequestCount();
            $newProductRequest = $this->productRequest->getNewProductRequest();
            return $this->handleResponse([
                "post_count" => $noOfPost,
                "newContact_count" => $noOfContact,
                "newEnquiry_count" => $noOfEnquiry,
                "newProductRequest_count" => $noOfProducRequest,
                "learning_count" => $noOfLearning,
                "subscription_count" => $noOfSubscriber,
                "new_contact" => new ContactCollection($newContact),
                "new_Enquiry" => new ServiceEnquiryCollection($newEnquiry),
                "new_product_request" => new ProductRequestCollection($newProductRequest),
            ], "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while retrieving data", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    
}
