<?php
namespace App\Services\Product;

use App\Repositories\Eloquent\Product\ProductRepositoryInterface;
use App\Services\Product\IProductService;
use App\Services\IStorageService;
use App\Events\ProductCreated as ProductCreatedEvent;
use Illuminate\Support\Facades\Cache;

class ProductService implements IProductService
{

    protected ProductRepositoryInterface $postRepository;
    private IStorageService $storage;

    public function __construct(ProductRepositoryInterface $postRepository, IStorageService $storage)
    {
        $this->postRepository = $postRepository;
        $this->storage = $storage;
    }

    public function createProduct($data)
    {
        if($updatedData = $this->storage->saveFile($data, "image")) {
            $post = $this->postRepository->create($updatedData);
            event(new ProductCreatedEvent($post));
            if (Cache::has('noOfProduct')) 
                Cache::increment('noOfProduct', 1);
            return $post;
        }
        // throw new Exception("Error Processing Request", 1);
        
    }

    public function getAllProduct($paginateValue = null)
    {
        return $this->postRepository->fetchAll($paginateValue);
    }

    public function getAllProductCount()
    {
        return Cache::remember('noOfProduct',3600, function () {
            return $this->postRepository->fetchAll()->count();
        });
    }

    public function updateProductById(array $data, int $id)
    {
        $post = $this->postRepository->findById($id);
        if(array_key_exists('image', $data)) {            
            $updatedDataWithImagePath = $this->storage->updateFile($post->image, $data);
            return $this->postRepository->updateById($updatedDataWithImagePath, $id);
        }
        
        return $this->postRepository->updateById($data, $id);
    }

    public function getProductById(int $id)
    {
        return $this->postRepository->findById($id);
    }

    public function getProductBySlug(string $id)
    {
        return $this->postRepository->findById($id);
    }

    public function deleteProductById(int|string $id)
    {
        $post = $this->postRepository->findById($id);
        $this->storage->deleteFile($post->image);
        $deletedProduct = $this->postRepository->delete($id);
        if (Cache::has('noOfProduct')) 
            Cache::decrement('noOfProduct', 1);
        return $deletedProduct;
    }
}