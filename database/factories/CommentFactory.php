<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Comment;
use App\User;
use App\Models\Post;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->text($maxNbChars = 200),
        'user_id' => User::all()->random()->id,
        'post_id' => Post::all()->random()->id
    ];
});
