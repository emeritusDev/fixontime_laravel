<?php
namespace App\Services\Post;

use App\Repositories\Eloquent\Post\PostRepositoryInterface;
use App\Services\Post\IPostService;
use App\Services\IStorageService;
use App\Events\PostCreated as PostCreatedEvent;
use Illuminate\Support\Facades\Cache;

class PostService implements IPostService
{

    protected $postRepository;
    private $storage;

    public function __construct(PostRepositoryInterface $postRepository, IStorageService $storage)
    {
        $this->postRepository = $postRepository;
        $this->storage = $storage;
    }

    public function createPost($data)
    {
        if($updatedData = $this->storage->saveFile($data, "image")) {
            $post = $this->postRepository->create($updatedData);
            event(new PostCreatedEvent($post));
            if (Cache::has('noOfPost')) 
                Cache::increment('noOfPost', 1);
            return $post;
        }
        // throw new Exception("Error Processing Request", 1);
        
    }

    public function getAllPost()
    {
        return $this->postRepository->fetchAll();
    }

    public function getAllPostCount()
    {
        return Cache::remember('noOfPost',3600, function () {
            return $this->postRepository->fetchAll()->count();
        });
    }

    public function updatePostById(array $data, int $id)
    {
        $post = $this->postRepository->findById($id);
        if(array_key_exists('image', $data)) {            
            $updatedDataWithImagePath = $this->storage->updateFile($post->image, $data);
            return $this->postRepository->updateById($updatedDataWithImagePath, $id);
        }
        
        return $this->postRepository->updateById($data, $id);
    }

    public function getPostById(int $id)
    {
        return $this->postRepository->findById($id);
    }

    public function getPostBySlug(string $id)
    {
        return $this->postRepository->findById($id);
    }

    public function deletePostById(int|string $id)
    {
        $post = $this->postRepository->findById($id);
        $this->storage->deleteFile($post->image);
        $deletedPost = $this->postRepository->delete($id);
        if (Cache::has('noOfPost')) 
            Cache::decrement('noOfPost', 1);
        return $deletedPost;
    }
}