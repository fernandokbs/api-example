<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Post;

class PostTest extends TestCase
{
    use RefreshDataBase, WithFaker;
    
    /**
     * @test
     */
    public function lists_posts()
    {
        $user = create('App\User');
        $post = create('App\Models\Post');
        $comment = create('App\Models\Comment', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]); 
        
        $response = $this->json('GET', $this->baseUrl . "posts");
        $response->assertStatus(200);
        
        $response
            ->assertJson([
             'data' => [
                 [
                    'type' => $post->getTable(),
                    'id' => $post->id,
                    
                    'attributes' => [
                        'title' => $post->title
                    ],

                    'relationships' => [
                        'author' => [
                            'links' => [
                                'self' => route('posts.show', ['article' => $post->id]),
                                'related' => route('post.relationships.author', ['user' => $post->id])
                            ],

                            'data' => [
                                'type' => $user->getTable(),
                                'id' => $user->id
                            ]
                        ],

                        'comments' => [
                            'links' => [
                                
                            ],

                            'data' => [
                                [

                                ]
                            ]
                        ]
                    ]
                 ]
             ]   
        ]); 
    }


    /**
     * @test
     */
    public function stores_a_post()
    {
        $user = create('App\User');

        $data = [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'content' => $this->faker->text($maxNbChars = 40),
            'author_id' => $user->id 
        ];

        $response = $this->json('POST', $this->baseUrl . 'posts', $data);
        $response->assertStatus(201);
        
        $this->assertEquals(1, $user->posts->count());
        
        $post = Post::all()->first();

        $response->assertJson([
            "type" => $post->getTable(),
            "id" => $post->id,
            "attributes" => [
                "title" => $post->title
            ],
            "links" => [
                'self' => route('posts.show', ['post' => $post->id]),
            ]
        ]);
    }

    /**
     * @test
     */
    public function shows_a_single_post()
    {
        $user = create('App\User');
        $post = create('App\Models\Post');
        $comment = create('App\Models\Comment');
        
        $response = $this->json('GET', $this->baseUrl . "posts/{$post->id}");
        $response->assertStatus(200);
        
        $response
            ->assertJson([
                'type' => $post->getTable(),
                'id' => $post->id,
                'attributes' => [
                    'title' => $post->title
                ],

                'links' => [
                    'self' => route('posts.show', ['post' => $post->id])
                ]

        ]); 
    }

    /**
     * @test
     */
    public function updates_a_post()
    {
        $post = create('App\Models\Post', [
            'title' => "Awesome title",
            'author_id' => create('App\User'),
            'content' => $this->faker->text($maxNbChars = 40)
        ]);
        
        $data = [
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'content' => $this->faker->text($maxNbChars = 40),
        ];

        $this->json('PUT', $this->baseUrl .  "posts/{$post->id}", $data)
            ->assertStatus(204);
        
        $post = $post->fresh();

        $this->assertEquals($post->title, $data['title']);
        $this->assertEquals($post->content, $data['content']);
    }

    /**
     * @test
     */
    public function deletes_a_post()
    {
        $post = create('App\Models\Post', ['author_id' => create('App\User')]);

        $this->json('DELETE', $this->baseUrl .  "posts/{$post->id}")
            ->assertStatus(200);
        
        $this->assertNull(Post::find($post->id));
    }
}
