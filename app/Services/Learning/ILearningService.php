<?php
namespace App\Services\Learning;

interface ILearningService 
{
    public function createLearning($data);

    public function getAllLearning();

    public function getAllLearningCount();

    public function updateLearningById(array $data, int $id);

    public function getLearningById(int $id);

    public function deleteLearningById(int|string $id);
}