<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $posts = [
            'id' => $this->id,
            'content' => $this->content,
            'author' => $this->user->username,
            'author_role' => $this->user->role->name,
            'author_image' => 'http://127.0.0.1:8000/storage/' . $this->user->picture_path,
            'like' => $this->like,
            'created_at' => date_format($this->created_at, 'Y/m/d H:i:s'),
            'comment_count' => $this->comment->count(),
        ];

        if($this->image_path){
            $posts['image'] = 'http://127.0.0.1:8000/storage/' . $this->image_path;
        }


        return $posts;
    }
}
