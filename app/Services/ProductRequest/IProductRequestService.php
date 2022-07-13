<?php
namespace App\Services\ProductRequest;

interface IProductRequestService 
{
    public function createProductRequest($data);

    public function getAllProductRequest();

    public function getAllProductRequestCount();

    public function getProductRequestById(int $id);

    public function deleteProductRequestById(int|string $id);

    public function getNewProductRequestCount();

    public function getNewProductRequest();
}