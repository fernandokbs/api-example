<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Collection;
use App\User;
use App\Models\Comment;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => PostResource::collection($this->collection),
        ];
    }

    public function with($request)
    {
        $authors = $this->collection->map(function($post) {
            return $post->author;
        });
        
        $comments = $this->collection->flatMap(function ($post) {
            return $post->comments;
        });

        $included = $authors->merge($comments);

        return [
            'links' => [
                'self' => route('posts.index'),
            ],

            'included' => $included->map(function($item) {
                if($item instanceof User)
                    return new UserResource($item);
                else if($item instanceof Comment)
                    return new CommentResource($item);
            })
        ];
    }
}
