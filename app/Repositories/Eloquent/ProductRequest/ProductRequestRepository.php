<?php

namespace App\Repositories\Eloquent\ProductRequest;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\ProductRequest\ProductRequestRepositoryInterface as IProductRequestRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Request;

class ProductRequestRepository extends ReadWriteModifyRepository  implements IProductRequestRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * ProductRequestRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Request $model)     
    {         
        $this->model = $model;
    }

    public function getNewProductRequest() {
        return $this->model->newProductRequest()->get();
    }

}