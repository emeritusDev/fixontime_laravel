<?php

namespace App\Repositories\Eloquent\Contact;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Eloquent\Contact\ContactRepositoryInterface as IContactRepository;
use App\Repositories\Eloquent\ReadWriteModifyRepository;
use App\Models\Contact;

class ContactRepository extends ReadWriteModifyRepository  implements IContactRepository
{
    /**      
     * @var Model      
     */     
    protected $model;       

    /**      
     * ContactRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Contact $model)     
    {         
        $this->model = $model;
    }

    public function getNewContact() {
        return $this->model->newContact()->get();
    }

}