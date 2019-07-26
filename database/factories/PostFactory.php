<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    
    $users = App\User::count();
    
    return [
        'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'author_id' => User::all()->random()->id,
        'content' => $faker->text($maxNbChars = 200)
    ];
});
