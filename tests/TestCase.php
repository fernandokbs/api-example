<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;
use Auth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $baseUrl = '/api/v1/';

    public function setUp(): void
    {
        parent::setUp();

        $this->singIn();
    }

    protected function singIn() 
    {
        Passport::actingAs(create('App\User'));
    } 

    public function logout()
    {
        $this->refreshApplication();
    }
}
