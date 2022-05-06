<?php
namespace App\Services;

interface IStorageService 
{
    public function saveFile(array $data, string $objectKey, string $path);

    public function updateFile(string $exitingFile, array $data, string $objectKey, string $path);

    public function deleteFile(string $path);

    public function putFile(array $data, string $objectKey, string $path);
}