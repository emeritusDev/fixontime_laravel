<?php

namespace App\Repositories\Eloquent\Category;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Category\CategoryRepositoryInterface as ICategoryRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Category;

class CategoryRepository extends ReadWriteModifyRepository  implements ICategoryRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * CategoryRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Category $model)     
    {         
        $this->model = $model;
    }

}