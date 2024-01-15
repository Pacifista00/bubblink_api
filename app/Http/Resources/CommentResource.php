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
            'content' => $this->content,
            'post_id' => $this->post_id,
            'author' => $this->user->username,
            'author_role' => $this->user->role->name,
            'author_image' => 'http://127.0.0.1:8000/storage/' . $this->user->picture_path,
            'created_at' => $this->created_at
        ];
    }
}
