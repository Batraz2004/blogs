<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentToNewsCreateRequest;
use App\Http\Requests\CommentToPostCreateRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function createToPost(CommentToPostCreateRequest $request)
    {
        $comment = $this->createComment($request);

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }

    public function createToNews(CommentToNewsCreateRequest $request)
    {
        $comment = $this->createComment($request);

        return response()->json([
            'data' => CommentResource::make($comment),
        ], 200);
    }

    private function createComment(CommentToNewsCreateRequest|CommentToPostCreateRequest $request): Comment
    {
        $comment = Comment::query()->create($request->getData());

        $comment->load('commentable');

        return $comment;
    }

    public function listByPost($postId, Request $request)
    {
        if (!Post::query()->where('id', $postId)->exists()) {
            abort(404);
        }

        $commentable = Post::class;

        $comments = $this->commentsList($commentable, $postId, $request);

        return response()->json([
            'data' => $comments,
        ], 200);
    }

    public function listByNews($newsId, Request $request)
    {
        if (!News::query()->where('id', $newsId)->exists()) {
            abort(404);
        }

        $commentable = News::class;

        $comments = $this->commentsList($commentable, $newsId, $request);

        return response()->json([
            'data' => $comments,
        ], 200);
    }

    private function commentsList(string $commentable, $id, $request): CursorPaginator
    {
        $perPage = $request->input('per_page', 15);

        $comments = Comment::isParent()
            ->with('childs')
            ->where('commentable_type', $commentable)
            ->where('commentable_id', $id)
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return $comments;
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
