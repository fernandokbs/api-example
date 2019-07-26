<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use \App\Http\Requests\UserRequest;
use Spatie\QueryBuilder\QueryBuilder;

use App\User;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = QueryBuilder::for(User::class)
            ->allowedIncludes('posts')
            ->allowedFilters('name','email');
        
        return new UserCollection($users->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        UserResource::withoutWrapping();

        $user = User::create($request->all());
        return (new UserResource($user))
            ->response()
            ->setStatusCode(201);
        //return ['status' => 201, 'data' => (new UserResource($user))];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        UserResource::withoutWrapping();
        return new UserResource($user);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        UserResource::withoutWrapping();
        return (new UserResource($user))
            ->response()
            ->setStatusCode(204);
        // return response(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 200); 
    }
}
