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

/** Allow OPTIONS request */
$router->options('{all:.*}', function () {
    return response()->json(null, 200);
});

$router->get('/', 'IndexController@index');

// Auth
$router->post('auth', [
    'uses' => 'AuthController@authenticate',
]);
$router->get('whoami', [
    'uses' => 'IndexController@whoami',
    'middleware' => ['auth'],
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

// Roles
$router->get('roles', [
    'uses' => 'RoleController@index',
    'middleware' => ['auth'],
]);

$router->post('roles', [
    'uses' => 'RoleController@store',
    'middleware' => ['auth'],
]);

$router->get('roles/{id}', [
    'uses' => 'RoleController@show',
    'middleware' => ['auth'],
]);

$router->patch('roles/{id}', [
    'uses' => 'RoleController@update',
    'middleware' => ['auth'],
]);

$router->delete('roles/{id}', [
    'uses' => 'RoleController@destroy',
    'middleware' => ['auth'],
]);

// AttendanceTypes
$router->get('attendance-types', [
    'uses' => 'AttendanceTypeController@index',
    'middleware' => ['auth'],
]);

// Calendars
$router->get('calendars', [
    'uses' => 'CalendarController@index',
    'middleware' => ['auth'],
]);
$router->post('calendars', [
    'uses' => 'CalendarController@store',
    'middleware' => ['auth'],
]);
$router->get('calendars/{id}', [
    'uses' => 'CalendarController@find',
    'middleware' => ['auth'],
]);
$router->patch('calendars/{id}', [
    'uses' => 'CalendarController@update',
    'middleware' => ['auth'],
]);
$router->delete('calendars/{id}', [
    'uses' => 'CalendarController@destroy',
    'middleware' => ['auth'],
]);
$router->get('calendars/{id}/events', [
    'uses' => 'CalendarController@getEvents',
    'middleware' => ['auth'],
]);
$router->post('calendars/{id}/events', [
    'uses' => 'CalendarController@addEvent',
    'middleware' => ['auth'],
]);
$router->patch('calendars/{calendar_id}/events/{event_id}', [
    'uses' => 'CalendarController@updateEvent',
    'middleware' => ['auth'],
]);
$router->delete('calendars/{calendar_id}/events/{event_id}', [
    'uses' => 'CalendarController@deleteEvent',
    'middleware' => ['auth'],
]);

// Workshifts
$router->get('workshifts', [
    'uses' => 'WorkshiftController@index',
    'middleware' => ['auth'],
]);
$router->post('workshifts', [
    'uses' => 'WorkshiftController@store',
    'middleware' => ['auth'],
]);
$router->get('workshifts/{id}', [
    'uses' => 'WorkshiftController@find',
    'middleware' => ['auth'],
]);
$router->patch('workshifts/{id}', [
    'uses' => 'WorkshiftController@update',
    'middleware' => ['auth'],
]);
$router->delete('workshifts/{id}', [
    'uses' => 'WorkshiftController@destroy',
    'middleware' => ['auth'],
]);
