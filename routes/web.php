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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/**
 * Request to generate a unique key for client applications.
 */
$router->get('/key/grant', 'KeyController@grant');
$router->get('/key/revoke', 'KeyController@revoke');

/**
 * Cart Routes
 */
$router->get('/cart/{id}', ['middleware' => 'auth', 'uses' => 'CartController@show']);
$router->post('/cart', ['middleware' => 'auth', 'uses' => 'CartController@store']);
$router->put('/cart/{id}', ['middleware' => 'auth', 'uses' => 'CartController@update']);
$router->delete('/cart/{id}', ['middleware' => 'auth', 'uses' => 'CartController@delete']);

/**
 * Cart Item Routes
 */
$router->get('/cartitem/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@show']);
$router->post('/cartitem', ['middleware' => 'auth', 'uses' => 'CartItemController@store']);
$router->put('/cartitem/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@update']);
$router->delete('/cartitem/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@delete']);
