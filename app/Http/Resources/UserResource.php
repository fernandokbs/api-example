<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user = Auth::user();

        return [
            'type' => $this->getTable(),
            'id' => (string) $this->id,

            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'posts' => PostResource::collection($this->whenLoaded('posts')),
                
                $this->mergeWhen($user->isAdmin(), [
                    'admin' => (bool) $user->isAdmin(),
                    'created_at' => $user->created_at
                ])
            ],
            
            'links' => [
                'self' => route('users.show', ['user' => $this->id]),
            ],
        ];
    }
}
