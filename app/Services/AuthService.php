<?php

namespace App\Services;

use App\Exceptions\Auth\ExpiredAccessTokenException;
use App\Exceptions\Auth\InvalidAccessTokenException;
use App\Exceptions\Auth\InvalidCredentialsException;
use App\User;
use App\AccessToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class AuthService
{
    /**
     * Authenticate a user and return access token.
     *
     * @param $name
     * @param $password
     * @return AccessToken
     * @throws InvalidCredentialsException
     */
    public function authenticate($name, $password): AccessToken
    {
        try {
            $user = User::where('name', $name)->firstOrFail();

            if (! password_verify($password, $user->password)) {
                throw new InvalidCredentialsException;
            }

            $now = Carbon::now();
            $access_token_data = [
                'username' => Str::random(32),
                'password' => Str::random(32),
                'generated_at' => $now,
                'last_used_at' => $now,
            ];

            $access_token = $user->accessTokens()->create($access_token_data);

            return $access_token;
        } catch (ModelNotFoundException $e) {
            throw new InvalidCredentialsException;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Authorize the user.
     *
     * @param $username
     * @param $password
     * @return mixed
     * @throws InvalidAccessTokenException
     */
    public function authorize($username, $password)
    {
        try {
            $now = Carbon::now();
            $access_token = AccessToken::with('user')
                ->where([
                    'username' => $username,
                    'password' => $password,
                ])
                ->firstOrFail();

            if ($access_token->last_used_at->addMinutes(env('ACCESS_TOKEN_AGE'))->lte($now)) {
                throw new ExpiredAccessTokenException;
            }

            $access_token->update(['last_used_at' => $now]);

            return $access_token->user;
        } catch (ModelNotFoundException $e) {
            throw new InvalidAccessTokenException;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}