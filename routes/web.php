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

// Ranks
$router->get('ranks', [
   'uses' => 'RankController@index',
]);

$router->post('ranks', [
    'uses' => 'RankController@store',
]);

$router->get('ranks/{id}', [
    'uses' => 'RankController@show',
]);

$router->patch('ranks/{id}', [
    'uses' => 'RankController@update',
]);

$router->delete('ranks/{id}', [
    'uses' => 'RankController@destroy',
]);
