<?php

namespace App\Repositories\Eloquent\Enquiry;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Enquiry\EnquiryRepositoryInterface as IEnquiryRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Enquiry;

class EnquiryRepository extends ReadWriteModifyRepository  implements IEnquiryRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * EnquiryRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Enquiry $model)     
    {         
        $this->model = $model;
    }

    public function getNewEnquiry() {
        return $this->model->newEnquiry()->get();
    }

}