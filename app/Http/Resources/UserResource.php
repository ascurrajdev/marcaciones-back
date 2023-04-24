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
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'role_id' => $this->resource->role_id,
            'department_id' => $this->resource->department_id,
            'role' => $this->whenLoaded("role"),
            'department' => $this->whenLoaded('department'),
            'created_at' => $this->resource->created_at,
        ];
    }
}
