<?php

namespace App\Repositories\Eloquent\Learning;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Learning\LearningRepositoryInterface as ILearningRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Learning;

class LearningRepository extends ReadWriteModifyRepository  implements ILearningRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * LearningRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Learning $model)     
    {         
        $this->model = $model;
    }

}