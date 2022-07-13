<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Category\ICategoryService;
use App\Services\Category\CategoryService;
use App\Services\Post\IPostService;
use App\Services\Post\PostService;
use App\Services\Comment\ICommentService;
use App\Services\Comment\CommentService;
use App\Services\Subscription\ISubscriptionService;
use App\Services\Subscription\SubscriptionService;
use App\Services\Contact\IContactService;
use App\Services\Contact\ContactService;
use App\Services\Learning\ILearningService;
use App\Services\Learning\LearningService;
use App\Services\Enquiry\IEnquiryService;
use App\Services\Enquiry\EnquiryService;
use App\Services\ProductRequest\IProductRequestService;
use App\Services\ProductRequest\ProductRequestService;
use App\Services\IStorageService;
use App\Services\LocalStorageService;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(IStorageService::class, LocalStorageService::class);
        $this->app->bind(IPostService::class, PostService::class);
        $this->app->bind(ICommentService::class, CommentService::class);
        $this->app->bind(ISubscriptionService::class, SubscriptionService::class);
        $this->app->bind(IContactService::class, ContactService::class);
        $this->app->bind(ILearningService::class, LearningService::class);
        $this->app->bind(IEnquiryService::class, EnquiryService::class);
        $this->app->bind(IProductRequestService::class, ProductRequestService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
