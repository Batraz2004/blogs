<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function list(Request $request)
    {
        $perPage = $request->input('per_page', 15);

        $news = News::query()
            ->orderByDesc('id')
            ->cursorPaginate($perPage);

        return response()->json([
            'data' => NewsResource::collection($news)->resource,
        ], 200);
    }

    public function create(NewsRequest $request)
    {
        $news = News::query()->create($request->getData());

        return response()->json([
            'data' => NewsResource::make($news),
        ], 200);
    }

    public function update($newsId, NewsRequest $request)
    {
        $news = News::query()->find($newsId);

        if (blank($news)) {
            abort(404);
        }

        $news->update($request->getData());

        return response()->json([
            'data' => NewsResource::make($news),
        ], 200);
    }

    public function get($newsId)
    {
        $news = News::query()
            ->find($newsId);

        if (blank($news)) {
            abort(404);
        }

        return response()->json([
            'data' => NewsResource::make($news),
        ], 200);
    }

    public function delete($newsId)
    {
        $news = News::query()->find($newsId);

        if (blank($news)) {
            abort(404);
        }

        $news->delete();

        return response()->json([
            'data' => NewsResource::make($news),
        ], 200);
    }
}
