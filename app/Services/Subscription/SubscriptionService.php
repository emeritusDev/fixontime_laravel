<?php
namespace App\Services\Subscription;

use App\Repositories\Eloquent\Subscription\SubscriptionRepositoryInterface;
use App\Services\Subscription\ISubscriptionService;
use Illuminate\Support\Facades\Cache;

class SubscriptionService implements ISubscriptionService
{

    protected $subscriptionRepository;

    public function __construct(SubscriptionRepositoryInterface $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function createSubscription($data)
    {
        $newSubscriber = $this->subscriptionRepository->create($data);
        if (Cache::has('noOfSubsciber')) 
            Cache::increment('noOfSubsciber', 1);
        return $newSubscriber;
    }

    public function getAllSubscription()
    {
        return $this->subscriptionRepository->fetchAll();
    }

    public function getAllSubscriptionCount()
    {
        return Cache::remember('noOfSubsciber',3600, function () {
            return $this->subscriptionRepository->fetchAll()->count();
        });
    }


    public function deleteSubscriptionById(int|string $id)
    {
        $deletedSubscriber = $this->subscriptionRepository->delete($id);
        if (Cache::has('noOfSubsciber')) 
            Cache::decrement('noOfSubsciber', 1);
        return $deletedSubscriber;
    }
}