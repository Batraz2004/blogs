<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;
use App\Http\Requests\CommentToNewsCreateRequest;
use App\Http\Requests\CommentToPostCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createToPost(CommentToPostCreateRequest $request)
    {
        $comment = Comment::query()->create($request->getData());

        $comment->load('commentable');

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }

    public function createToNews(CommentToNewsCreateRequest $request)
    {
        $comment = Comment::query()->create($request->getData());

        $comment->load('commentable');

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }

    public function listByPost($postId, Request $request)
    {
        if (!Post::query()->where('id', $postId)->exists()) {
            abort(404);
        }

        $perPage = $request->input('per_page', 15);

        $comments = Comment::isParent()
            ->with('childs')
            ->where('commentable_type', Post::class)
            ->where('commentable_id', $postId)
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        if (blank($comments)) {
            abort(404);
        }

        return response()->json([
            'data' => CommentResource::collection($comments)->resource,
        ], 200);
    }

    public function listByNews($newsId, Request $request)
    {
        if (!News::query()->where('id', $newsId)->exists()) {
            abort(404);
        }

        $perPage = $request->input('per_page', 15);

        $comments = Comment::isParent()
            ->with('childs')
            ->where('commentable_type', News::class)
            ->where('commentable_id', $newsId)
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        if (blank($comments)) {
            abort(404);
        }

        return response()->json([
            'data' => CommentResource::collection($comments)->resource,
        ], 200);
    }

    public function listByUser(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $perPage = $request->input('per_page', 15);

        $comments = $user
            ->comments()
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return response()->json([
            'data' => CommentResource::collection($comments)->resource,
        ], 200);
    }

    public function update($commentId, CommentUpdateRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Post $post */
        $comment = $user
            ->comments()
            ->find($commentId);

        if (blank($comment)) {
            abort(404);
        }

        $comment->update($request->getData());

        $comment->load('user');

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }

    public function delete($commentId)
    {
        /** @var User $user */
        $user = Auth::user();

        $comment = $user
            ->comments()
            ->find($commentId);

        if (blank($comment)) {
            abort(404);
        }

        $comment->delete();

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }
}
