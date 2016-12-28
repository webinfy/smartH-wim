<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::defaultRouteClass(DashedRoute::class);

Router::prefix('admin', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->fallbacks('DashedRoute');
});

Router::prefix('branchadmin', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->fallbacks('DashedRoute');
});

Router::prefix('merchant', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login/*', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->fallbacks('DashedRoute');
});

Router::prefix('customer', function ($routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login/*', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout/*', ['controller' => 'Users', 'action' => 'logout']);

    $routes->connect('/pay-now/*', ['controller' => 'Payments', 'action' => 'payNow']);
    $routes->connect('/view-transactions/*', ['controller' => 'Payments', 'action' => 'viewTransactions']);

    $routes->connect('/send-otp/*', ['controller' => 'Payments', 'action' => 'sendOtp']);
    $routes->connect('/validate-otp/*', ['controller' => 'Payments', 'action' => 'validateOtp']);
    $routes->connect('/register/*', ['controller' => 'Payments', 'action' => 'register']);
    $routes->connect('/resend-otp/*', ['controller' => 'Payments', 'action' => 'resendOtp']);
    $routes->connect('/confirm-login/*', ['controller' => 'Payments', 'action' => 'confirmLogin']);

    $routes->fallbacks('DashedRoute');
});


Router::scope('/', function (RouteBuilder $routes) {
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
    $routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgotPassword']);
    $routes->connect('/forgot-password-otp/*', ['controller' => 'Users', 'action' => 'forgotPasswordOtp']);
    $routes->connect('/reset-password/*', ['controller' => 'Users', 'action' => 'resetPassword']);
    $routes->connect('/term-and-conditions', ['controller' => 'Pages', 'action' => 'termAndConditions']);
    $routes->fallbacks(DashedRoute::class);
});

Plugin::routes();
