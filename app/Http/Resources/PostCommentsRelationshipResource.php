<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCommentsRelationshipResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $article = $this->additional['post'];

        return [
            'data'  => CommentIdentifierResource::collection($this->collection),

            'links' => [
                'self' => route('posts.relationships.comments', ['post' => $article->id]),
                'related' => route('posts.relationships.comments', ['post' => $article->id]),
            ]
        ];
    }
}
