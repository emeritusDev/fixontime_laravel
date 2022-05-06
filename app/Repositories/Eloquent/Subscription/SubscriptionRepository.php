<?php

namespace App\Repositories\Eloquent\Subscription;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Subscription\SubscriptionRepositoryInterface as ISubscriptionRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Subscription;

class SubscriptionRepository extends ReadWriteModifyRepository  implements ISubscriptionRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * SubscriptionRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Subscription $model)     
    {         
        $this->model = $model;
    }

}