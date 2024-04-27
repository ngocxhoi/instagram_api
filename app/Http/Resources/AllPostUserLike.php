<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllPostUserLike extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($postsLike) {
            return [
                'id' => $postsLike->posts->id,
                'file' => $postsLike->posts->file,
            ];
        });
    }
}
