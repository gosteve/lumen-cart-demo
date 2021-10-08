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
$router->post('/key', 'KeyController@store');
$router->delete('/key/{id}', 'KeyController@delete');

/**
 * Cart Routes
 */
$router->get('/carts/{id}', ['middleware' => 'auth', 'uses' => 'CartController@show']);
$router->post('/carts', ['middleware' => 'auth', 'uses' => 'CartController@store']);
$router->put('/carts/{id}', ['middleware' => 'auth', 'uses' => 'CartController@update']);
$router->delete('/carts/{id}', ['middleware' => 'auth', 'uses' => 'CartController@delete']);

/**
 * Cart Item Routes
 */
$router->get('/cartitems/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@show']);
$router->post('/cartitems', ['middleware' => 'auth', 'uses' => 'CartItemController@store']);
$router->put('/cartitems/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@update']);
$router->delete('/cartitems/{id}', ['middleware' => 'auth', 'uses' => 'CartItemController@delete']);
