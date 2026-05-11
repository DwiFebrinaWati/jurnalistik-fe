<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => [
                'id' => $this->role_id,
                'name' => $this->role->role_name ?? 'N/A',
            ],
            'joined_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}