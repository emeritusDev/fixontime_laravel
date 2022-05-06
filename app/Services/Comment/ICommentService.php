<?php
namespace App\Services\Comment;

interface ICommentService 
{
    public function createComment($data);

    public function deleteCommentById(int|string $id);
}