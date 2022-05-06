<?php
namespace App\Services\Learning;

use App\Repositories\Eloquent\Learning\LearningRepositoryInterface;
use App\Services\Learning\ILearningService;
use App\Services\IStorageService;
use Illuminate\Support\Facades\Cache;

class LearningService implements ILearningService
{

    protected $learningRepository;
    private $storage;

    public function __construct(LearningRepositoryInterface $learningRepository, IStorageService $storage)
    {
        $this->learningRepository = $learningRepository;
        $this->storage = $storage;
    }

    public function createLearning($data)
    {
        $DIR = "images/thumbnails/";
        $FILE_KEY = "thumbnail";
        if($updatedData = $this->storage->saveFile($data, $FILE_KEY, $DIR)){
            $newLearningMaterial = $this->learningRepository->create($updatedData);
            if (Cache::has('noOfLearning')) 
                Cache::increment('noOfLearning', 1);
            return $newLearningMaterial;
        }
        // throw new Exception("Error Processing Request", 1);
        
    }

    public function getAllLearning()
    {
        return $this->learningRepository->fetchAll();
    }

    public function getAllLearningCount()
    {
        return Cache::remember('noOfLearning',3600, function () {
            return $this->learningRepository->fetchAll()->count();
        });
    }

    public function updateLearningById(array $data, int $id)
    {
        $learning = $this->learningRepository->findById($id);    
        $FILE_KEY = "thumbnail";
        if(array_key_exists($FILE_KEY, $data)) {
            $DIR = "images/thumbnails/";
            $updatedDataWithImagePath = $this->storage->updateFile($learning->thumbnail, $data, $FILE_KEY, $DIR);
            return $this->learningRepository->updateById($updatedDataWithImagePath, $id);
        }
        
        return $this->learningRepository->updateById($data, $id);
    }

    public function getLearningById(int $id)
    {
        return $this->learningRepository->findById($id);
    }

    public function deleteLearningById(int|string $id)
    {
        $learning = $this->learningRepository->findById($id);
        $this->storage->deleteFile($learning->thumbnail);
        $deletedLearningMaterial = $this->learningRepository->delete($id);
        if (Cache::has('noOfLearning')) 
            Cache::decrement('noOfLearning', 1);
        return $deletedLearningMaterial;
    }
}