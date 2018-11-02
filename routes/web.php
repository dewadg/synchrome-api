<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', 'IndexController@index');

// Auth
$router->post('auth', [
   'uses' => 'AuthController@authenticate',
]);

// Ranks
$router->get('ranks', [
    'uses' => 'RankController@index',
    'middleware' => ['auth'],
]);

$router->post('ranks', [
    'uses' => 'RankController@store',
    'middleware' => ['auth'],
]);

$router->get('ranks/{id}', [
    'uses' => 'RankController@show',
    'middleware' => ['auth'],
]);

$router->patch('ranks/{id}', [
    'uses' => 'RankController@update',
    'middleware' => ['auth'],
]);

$router->delete('ranks/{id}', [
    'uses' => 'RankController@destroy',
    'middleware' => ['auth'],
]);
