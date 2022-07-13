<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\IReadOnlyRepository;
use App\Repositories\IWriteModifyRepository;
use App\Repositories\Eloquent\WriteModifyRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Repositories\Eloquent\ReadOnlyRespository;

use App\Repositories\Eloquent\Category\CategoryRepository;
use App\Repositories\Eloquent\Category\CategoryRepositoryInterface;

use App\Repositories\Eloquent\Post\PostRepository;
use App\Repositories\Eloquent\Post\PostRepositoryInterface;

use App\Repositories\Eloquent\Comment\CommentRepository;
use App\Repositories\Eloquent\Comment\CommentRepositoryInterface;

use App\Repositories\Eloquent\Subscription\SubscriptionRepository;
use App\Repositories\Eloquent\Subscription\SubscriptionRepositoryInterface;

use App\Repositories\Eloquent\Contact\ContactRepository;
use App\Repositories\Eloquent\Contact\ContactRepositoryInterface;

use App\Repositories\Eloquent\Learning\LearningRepository;
use App\Repositories\Eloquent\Learning\LearningRepositoryInterface;

use App\Repositories\Eloquent\ProductRequest\ProductRequestRepository;
use App\Repositories\Eloquent\ProductRequest\ProductRequestRepositoryInterface;

use App\Repositories\Eloquent\Enquiry\EnquiryRepository;
use App\Repositories\Eloquent\Enquiry\EnquiryRepositoryInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IWriteModifyRepository::class, WriteModifyRepository::class);
        $this->app->bind(IReadOnlyRepository::class, ReadOnlyRespository::class);
        $this->app->bind(IReadOnlyRepository::class, ReadWriteModifyRepository::class);
        $this->app->bind(IWriteModifyRepository::class, ReadWriteModifyRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(SubscriptionRepositoryInterface::class, SubscriptionRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(LearningRepositoryInterface::class, LearningRepository::class);
        $this->app->bind(ProductRequestRepositoryInterface::class, ProductRequestRepository::class);
        $this->app->bind(EnquiryRepositoryInterface::class, EnquiryRepository::class);
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
