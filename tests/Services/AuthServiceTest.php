<?php

use App\Services\AuthService;
use Laravel\Lumen\Testing\DatabaseMigrations;

class AuthServiceTest extends TestCase
{
    use DatabaseMigrations;

    protected $test_auth_service;

    public function setUp()
    {
        parent::setUp();

        $seeder = app(DatabaseSeeder::class);
        $seeder->call('AccessesTableSeeder');
        $seeder->call('RolesTableSeeder');
        $seeder->call('UsersTableSeeder');

        $this->test_auth_service = new AuthService;
    }

    public function testAuthenticate()
    {
        $access_token = $this->test_auth_service->authenticate('su', 'supersu');

        $this->assertInstanceOf(\App\AccessToken::class, $access_token);
    }

    public function testAuthorize()
    {
        $access_token = $this->test_auth_service->authenticate('su', 'supersu');
        $user = $this->test_auth_service->authorize($access_token->username, $access_token->password);

        $this->assertTrue($user->id === $access_token->user->id);
    }
}
