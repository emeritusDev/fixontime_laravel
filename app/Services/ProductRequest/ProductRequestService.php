<?php
namespace App\Services\ProductRequest;

use App\Repositories\Eloquent\ProductRequest\ProductRequestRepositoryInterface;
use App\Services\ProductRequest\IProductRequestService;
use Illuminate\Support\Facades\Cache;

class ProductRequestService implements IProductRequestService
{

    protected $productRequestRepository;

    public function __construct(ProductRequestRepositoryInterface $productRequestRepository)
    {
        $this->productRequestRepository = $productRequestRepository;
    }

    public function createProductRequest($data)
    {
        $newProductRequest = $this->productRequestRepository->create($data);
        if (Cache::has('noOfProductRequest')) 
            Cache::increment('noOfProductRequest', 1);
        return $newProductRequest;
    }

    public function getAllProductRequest()
    {
        return $this->productRequestRepository->fetchAll();
    }

    public function getAllProductRequestCount()
    {
        return Cache::remember('noOfProductRequest',3600, function () {
            return $this->productRequestRepository->fetchAll()->count();
        });
    }

    public function getNewProductRequest()
    {
        return $this->productRequestRepository->getNewProductRequest();
    }

    public function getNewProductRequestCount()
    {
        return $this->productRequestRepository->getNewProductRequest()->count();
    }

    public function getProductRequestById(int $id)
    {
        return $this->productRequestRepository->findById($id);
    }

    public function deleteProductRequestById(int|string $id)
    {
        $deletedProductRequest = $this->productRequestRepository->delete($id);
        if (Cache::has('noOfProductRequest')) 
            Cache::decrement('noOfProductRequest', 1);
        return $deletedProductRequest;
    }
}