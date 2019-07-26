<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->times(10)->create();
        factory(\App\Models\Post::class)->times(5)->create();
        factory(\App\Models\Comment::class)->times(3)->create();
        #$this->call(UsersTableSeeder::class);
    }
}
