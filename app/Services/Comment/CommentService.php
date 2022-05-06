<?php
namespace App\Services\Comment;

use App\Repositories\Eloquent\Comment\CommentRepositoryInterface;
use App\Services\Comment\ICommentService;

class CommentService implements ICommentService
{

    protected $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment($data)
    {
        return $this->commentRepository->create($data);
    }

    public function deleteCommentById(int|string $id)
    {
        return $this->commentRepository->delete($id);
    }
}