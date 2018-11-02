<?php

namespace App\Exceptions\Auth;

class InvalidCredentialsException extends \Exception
{
    protected $message = 'Wrong username/password';
}