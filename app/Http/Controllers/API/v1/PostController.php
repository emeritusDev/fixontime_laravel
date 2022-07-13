<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Post\PostCollection;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\Post\Post as PostMiniResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Post\IPostService;
use App\Http\Requests\post\StorePostRequest;
use App\Http\Requests\post\UpdatePostRequest;

class PostController extends BaseController
{
    private IPostService $post;

    public function __construct(IPostService $post)
    {
        $this->middleware('auth:sanctum', ['except' => ['index','show']]);
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    {
        $paginateValue = $request->query('paginate');
        try {
            if($paginateValue)
                return PostMiniResource::collection($this->post->getAllPost($paginateValue));
            return $this->handleResponse(PostMiniResource::collection($this->post->getAllPost()), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while retrieving available post", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        try {
            return $this->handleResponse(new PostResource($this->post->createPost($request->validated())), "post saved successfully", Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while creating post", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return $this->handleResponse(new PostResource($this->post->getPostById($id)), "", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while retriving post with id - ".$id, [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        try {
            return $this->handleResponse(new PostResource($this->post->updatePostById($request->validated(), $id)), "Post details updated successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError("An error occur while updating post information", [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->post->deletePostById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError($err->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
