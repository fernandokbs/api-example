<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;

class AuthPassportTest extends TestCase
{
    use RefreshDataBase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function unauthenticated()
    {
        $this->logout();
        
        $response = $this->json('GET', $this->baseUrl . "users");
        $response->assertStatus(401);
    }

    /**
     * @test
     */
    public function login()
    {
        $this->singIn();

        $response = $this->json('GET', $this->baseUrl . "users");
        $response->assertStatus(200);
    }
}
