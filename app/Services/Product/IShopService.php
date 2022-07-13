<?php
namespace App\Services\Product;

interface IProductService 
{
    public function createProduct(array $data);

    public function getAllProduct(int $paginateValue);

    public function getAllProductCount();

    public function updateProductById(array $data, int $id);

    public function getProductById(int $id);

    public function getProductBySlug(string $id);

    public function deleteProductById(int|string $id);
}