<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 15);

        $posts = Post::query()
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return response()->json([
            'data' => PostResource::collection($posts)->resource,
        ], 200);
    }

    public function create(PostRequest $request)
    {
        $post = Post::query()->create($request->getData());

        $post->addMedia($request->video)->toMediaCollection('blog-videos');

        $post->load('user');

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }

    public function update($postId, PostRequest $request)
    {
        $post = Post::query()->find($postId);

        if (blank($post)) {
            abort(404);
        }

        $post->update($request->getData());

        $post->deleteAllMedia();
        $post->addMedia($request->video)->toMediaCollection('blog-videos');

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }

    public function get($postId)
    {
        $post = Post::query()
            ->find($postId);

        if (blank($post)) {
            abort(404);
        }

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }

    public function delete($postId)
    {
        $post = Post::query()->find($postId);

        if (blank($post)) {
            abort(404);
        }

        $post->delete();

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }
}
