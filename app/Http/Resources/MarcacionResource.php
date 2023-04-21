<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MarcacionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "type" => $this->resource->type,
            "datetime" => $this->resource->datetime->format("Y-m-d H:i:s"),
            "position" => $this->resource->position,
            "overtime" => $this->resource->overtime->format("H:i:s"),
            "user" => $this->whenLoaded("user"),
        ];
    }
}
