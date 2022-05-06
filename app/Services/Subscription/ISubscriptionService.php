<?php
namespace App\Services\Subscription;

interface ISubscriptionService 
{
    public function createSubscription($data);

    public function getAllSubscription();

    public function getAllSubscriptionCount();

    public function deleteSubscriptionById(int|string $id);
}