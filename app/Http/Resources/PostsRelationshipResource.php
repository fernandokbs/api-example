<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostsRelationshipResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'author' => [
                'links' => [
                    'self' => route('posts.show', ['article' => $this->id]),
                    'related' => route('post.relationships.author', ['user' => $this->id])
                ], 
                
                'data'  => new AuthorIdentifierResource($this->author),
            ],

            'comments' => (new PostCommentsRelationshipResource($this->comments))->additional(["post" => $this])
        ];
    }
}
