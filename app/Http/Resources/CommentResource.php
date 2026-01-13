<?php

namespace App\Http\Resources;

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
        return [
            'id' => $this->id,
            'message' => $this->message,
            'post_id' => $this->post_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'chlids'  => CommentResource::collection($this->whenLoaded('childs'))->resource,
        ];
    }
}
