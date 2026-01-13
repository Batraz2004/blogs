<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\News;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        [$commentable, $type] = $this->getCommentableIdAndType();

        return [
            'id' => $this->id,
            'message' => $this->message,
            'commentable' => $this->whenNotNull($commentable),
            'comment_type' => $this->whenNotNull($type),
            'chlids'  => CommentResource::collection($this->whenLoaded('childs'))->resource,
        ];
    }

    private function getCommentableIdAndType(): array
    {
        /** @var Comment&self $this */

        if (!$this->relationLoaded('commentable')) {
            return [null, null];
        }

        if ($this->commentable instanceof Post) {
            return [PostResource::make($this->commentable), 'post'];
        }

        if ($this->commentable instanceof News) {
            return [NewsResource::make($this->commentable), 'news'];
        }

        return [null, null];
    }
}
