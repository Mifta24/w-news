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
            'comments_content' => $this->comments_content,
            'post' => $this->whenLoaded('post',function(){
                return $this->post->loadMissing('author:id,username');
            }),
            'comentator' => $this->whenLoaded('user'),
        ];
    }
}
