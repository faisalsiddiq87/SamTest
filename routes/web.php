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

$router->get('/', function() use($router) {
    return $router->app->version();
});

$router->group(['prefix'=>'api/v1', 'middleware' => ['throttle:60,1']], function() use($router) {
    $router->post('auth/login', ['uses' => 'AuthController@authenticate']);

    $router->group(['prefix'=>'order', 'middleware' => ['jwt.auth']], function() use($router) {
        $router->get('/', ['uses' => 'OrderController@getAllOrders']);
        $router->post('create', ['uses' => 'OrderController@createOrder']);
        $router->get('check-status/{id:[0-9]+}', ['uses' => 'OrderController@checkOrderStatus']);
        $router->put('cancel-order/{id:[0-9]+}', ['uses' => 'OrderController@cancelOrder']);
    });

    $router->post('payment', ['middleware' => 'jwt.auth', 'uses' => 'PaymentController@processPayment']);
});