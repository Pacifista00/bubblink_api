<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role->name,
            'bio' => $this->bio,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'picture' => "http://127.0.0.1:8000/storage/" . $this->picture_path,
        ];
    }
}
