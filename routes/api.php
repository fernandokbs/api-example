<?php

Route::group([
    "prefix" => "v1",
    "namespace" => "Api\V1",
    "middleware" => ['auth:api']
], function() {
    Route::apiResources([
        'users' => 'UserController',
        'posts' =>  'PostController',
        'comments' => 'CommentController'
    ]);
    
    Route::get('/posts/{post}/relationships/comments', 'PostRelationShipController@comments')->name('posts.relationships.comments');

    Route::get('/posts/{post}/comments', 'PostRelationShipController@comments')->name('posts.comments');

    Route::get('/posts/{post}/relationships/author', 'PostRelationShipController@author')->name('post.relationships.author');

    Route::get('/posts/{post}/author', 'PostRelationShipController@author')->name('post.author');
});

Route::post('login', 'Api\AuthController@login');
Route::post('signup', 'Api\AuthController@signup');
