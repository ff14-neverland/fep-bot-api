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

//API Part
$router->get('export', ['uses' => 'ApiController@exportData']);
$router->get('status', ['uses' => 'ApiController@showStatus']);
$router->get('battle', ['uses' => 'ApiController@startBattle']);
$router->get('level', ['uses' => 'ApiController@levelUp']);
$router->post('update', ['uses' => 'ApiController@updateCharaInfo']);

//UI Part
$router->get('/', ['uses' => 'UiController@showIndex']);
$router->get('/ui/status', ['uses' => 'UiController@showStatusForm']);
$router->post('/ui/status', ['uses' => 'UiController@getCharaStatus']);
$router->post('/ui/battle', ['uses' => 'UiController@getBattleResult']);
