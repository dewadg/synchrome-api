<?php

namespace App\Exceptions\Auth;

class ExpiredAccessTokenException extends \Exception
{
    protected $message = 'Expired access token';
}