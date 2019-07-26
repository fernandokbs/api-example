<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Post;
use App\Models\User;

use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;

class PostRelationShipController extends Controller
{
    public function comments(Post $post)
    {
        return CommentResource::collection($post->comments);
    }

    public function author(Post $post)
    {
        return new UserResource($post->author);
    }
}
