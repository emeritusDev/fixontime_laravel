<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use App\Http\Resources\Comment\CommentCollection;
use App\Http\Resources\Comment\CommentResource;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Services\Comment\ICommentService;
use App\Http\Requests\Comment\StoreCommentRequest;

class CommentController extends BaseController
{
    private $comment;

    public function __construct(ICommentService $comment)
    {
        $this->middleware('auth:sanctum', ['except' => ['store']]);
        $this->comment = $comment;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCommentRequest $request)
    {
        try {
            return $this->handleResponse(new CommentResource($this->comment->createComment($request->validated())), "comment saved successfully", Response::HTTP_CREATED);
        } catch (\Throwable $err) {
            report($err);
            return $err;
            return $this->handleError("An error occur while creating comment", [], Response::HTTP_INTERNAL_SERVER_ERROR );
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
            $this->comment->deleteCommentById($id);
            return $this->handleResponse([], "deleted successfully", Response::HTTP_OK);
        } catch (\Throwable $err) {
            report($err);
            return $this->handleError($e->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR );
        }
    }
}
