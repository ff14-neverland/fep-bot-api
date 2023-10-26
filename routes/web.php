<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//API Part
$router->get('status', ['uses' => 'ApiController@showStatus']);
$router->get('battle', ['uses' => 'ApiController@startBattle']);
$router->get('level', ['uses' => 'ApiController@levelUp']);
$router->post('update', ['uses' => 'ApiController@updateCharaInfo']);

//UI Part
