<?php

namespace App\Exceptions\Auth;

class InvalidAccessTokenException extends \Exception
{
    protected $message = 'Invalid access token';
}