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

class AnalyticsController extends BaseController
{
    private IPostService $post;
    private ISubscriptionService $subscription;
    private IContactService $contact;
    private ILearningService $learning;

    public function __construct(
        IPostService $post,
        ISubscriptionService $subscription,
        IContactService $contact,
        ILearningService $learning,
    )
    {
        $this->middleware('auth:sanctum');
        $this->post = $post;
        $this->subscription = $subscription;
        $this->contact = $contact;
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
            $noOfPost = $this->post->getAllPostCount();
            $noOfSubsciber = $this->subscription->getAllSubscriptionCount();
            $noOfLearning = $this->learning->getAllLearningCount();
            $noOfContact = $this->contact->getAllContactCount();
            return $this->handleResponse([
                "post_count" => $noOfPost,
                "newContact_count" => $noOfContact,
                "learning_count" => $noOfLearning,
                "subscription_count" => $noOfSubsciber,
            ], "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retrieving data", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    
}
