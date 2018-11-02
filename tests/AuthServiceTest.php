<?php

use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Services\AuthService;

class AuthServiceTest extends TestCase
{
    use DatabaseTransactions;

    public function testAuthenticate()
    {
        $service = new AuthService;

        $access_token = $service->authenticate('su', 'supersu');

        $this->assertInstanceOf(\App\AccessToken::class, $access_token);
    }

    public function testAuthorize()
    {
        $service = new AuthService;

        $access_token = $service->authenticate('su', 'supersu');
        $user = $service->authorize($access_token->username, $access_token->password);

        $this->assertTrue($user->id === $access_token->user->id);
    }
}
