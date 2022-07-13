<?php
namespace App\Services\Enquiry;

use App\Repositories\Eloquent\Enquiry\EnquiryRepositoryInterface;
use App\Services\Enquiry\IEnquiryService;
use Illuminate\Support\Facades\Cache;

class EnquiryService implements IEnquiryService
{

    protected $EnquiryRepository;

    public function __construct(EnquiryRepositoryInterface $EnquiryRepository)
    {
        $this->EnquiryRepository = $EnquiryRepository;
    }

    public function createEnquiry($data)
    {
        $newEnquiry = $this->EnquiryRepository->create($data);
        if (Cache::has('noOfEnquiry')) 
            Cache::increment('noOfEnquiry', 1);
        return $newEnquiry;
    }

    public function getAllEnquiry()
    {
        return $this->EnquiryRepository->fetchAll();
    }

    public function getAllEnquiryCount()
    {
        return Cache::remember('noOfEnquiry',3600, function () {
            return $this->EnquiryRepository->fetchAll()->count();
        });
    }

    public function getNewEnquiry()
    {
        return $this->EnquiryRepository->getNewEnquiry();
    }

    public function getNewEnquiryCount()
    {
        return $this->EnquiryRepository->getNewEnquiry()->count();
    }

    public function getEnquiryById(int $id)
    {
        return $this->EnquiryRepository->findById($id);
    }

    public function deleteEnquiryById(int|string $id)
    {
        $deletedEnquiry = $this->EnquiryRepository->delete($id);
        if (Cache::has('noOfEnquiry')) 
            Cache::decrement('noOfEnquiry', 1);
        return $deletedEnquiry;
    }
}