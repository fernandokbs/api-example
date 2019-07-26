<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDataBase, WithFaker;
    
    /**
     * @test
     */
    public function stores_a_user()
    {
        $data = [
            'name' => 'Fernando',
            'email' => 'test@gmai.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', $this->baseUrl . 'users', $data);
        $response
            ->assertStatus(201);
        
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @test
     */
    public function shows_a_single_user()
    {
        $user = create('App\User', [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ]);
        
        $response = $this->json('GET', $this->baseUrl . "users/{$user->id}");
        $response->assertStatus(200);

        $response
            ->assertExactJson([
                'type' => $user->getTable(),
                'id' => (string)$user->id,
                'attributes' => [
                    'name' => $user->name,
                    'email' => $user->email
                ],

                'links' => [
                    'self' => route('users.show', ['user' => $user->id]),
                ],
            ]);
    }

    /**
     * @test
     */
    public function shows_a_single_user_fails_404()
    {
        $response = $this->json('GET', $this->baseUrl . 'users/f');
        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Resource item not found.'
        ]);
    }

    /**
     * @test
     */
    public function updates_a_user()
    {
        $user = create('App\User');
        
        $data = [
            'name' => 'Luis',
            'email' => 'fernando@codigofacilito' 
        ];

        $this->json('PUT', $this->baseUrl .  "users/{$user->id}", $data)
            ->assertStatus(204);
        
        $user = $user->fresh();

        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->email, $data['email']);
    }

    /**
     * @test
     */
    public function deletes_a_posts()
    {
        $user = create('App\User');
        $this->json('DELETE', $this->baseUrl .  "users/{$user->id}")
            ->assertStatus(200);
        
        $this->assertNull(User::find($user->id));
    }
}
