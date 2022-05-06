<?php
namespace App\Services\Category;

interface ICategoryService 
{
    public function createCategory($data);

    public function getAllCategory();

    public function updateCategoryById(array $data, int $id);

    public function getCategoryById(int $id);

    public function deleteCategoryById(int|string $id);
}