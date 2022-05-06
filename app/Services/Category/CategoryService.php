<?php
namespace App\Services\Category;

use App\Repositories\Eloquent\Category\CategoryRepositoryInterface;
use App\Services\Category\ICategoryService;

class CategoryService implements ICategoryService
{

    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->create($data);
    }

    public function getAllCategory()
    {
        return $this->categoryRepository->fetchAll();
    }

    public function updateCategoryById(array $data, int $id)
    {
        return $this->categoryRepository->updateById($data, $id);
    }

    public function getCategoryById(int $id)
    {
        return $this->categoryRepository->findById($id);
    }

    public function deleteCategoryById(int|string $id)
    {
        return $this->categoryRepository->delete($id);
    }
}