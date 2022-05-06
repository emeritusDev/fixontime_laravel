<?php
namespace App\Services\Contact;

use App\Repositories\Eloquent\Contact\ContactRepositoryInterface;
use App\Services\Contact\IContactService;
use Illuminate\Support\Facades\Cache;

class ContactService implements IContactService
{

    protected $contactRepository;

    public function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function createContact($data)
    {
        $newContact = $this->contactRepository->create($data);
        if (Cache::has('noOfContact')) 
            Cache::increment('noOfContact', 1);
        return $newContact;
    }

    public function getAllContact()
    {
        return $this->contactRepository->fetchAll();
    }

    public function getAllContactCount()
    {
        return Cache::remember('noOfContact',3600, function () {
            return $this->contactRepository->fetchAll()->count();
        });
    }

    public function getContactById(int $id)
    {
        return $this->contactRepository->findById($id);
    }

    public function deleteContactById(int|string $id)
    {
        $deletedContact = $this->contactRepository->delete($id);
        if (Cache::has('noOfContact')) 
            Cache::decrement('noOfContact', 1);
        return $deletedContact;
    }
}