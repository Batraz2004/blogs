<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 5);

        $posts = Post::query()
            ->with('user')
            ->paginate($perPage);

        return response()->json([
            'data' => PostResource::collection($posts)->resource,
        ], 200);
    }

    public function create(PostRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $post = Post::query()->create([
            'title' => $request->title,
            'text' => $request->text,
            'user_id' => $user->id,
        ]);

        $post->addMedia($request->video)->toMediaCollection('blog-videos');

        $post->load('user');

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }

    public function update($postId, PostRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var Post $post */
        $post = $user
            ->posts()
            ->find($postId);

        if (blank($post)) {
            abort(404);
        }

        $post->update([
            'title' => $request->title,
            'text' => $request->text,
        ]);

        $post->load('user');

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

        $post->load('user');

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }

    public function delete($postId)
    {
        /** @var User $user */
        $user = Auth::user();

        $post = $user
            ->posts()
            ->find($postId);

        if (blank($post)) {
            abort(404);
        }

        $post->delete();

        return response()->json([
            'data' => PostResource::make($post),
        ], 200);
    }
}
