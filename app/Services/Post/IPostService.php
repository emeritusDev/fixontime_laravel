<?php
namespace App\Services\Post;

interface IPostService 
{
    public function createPost($data);

    public function getAllPost();

    public function getAllPostCount();

    public function updatePostById(array $data, int $id);

    public function getPostById(int $id);

    public function getPostBySlug(string $id);

    public function deletePostById(int|string $id);
}