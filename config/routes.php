<?php

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::prefix('admin', function ($routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

//    $routes->connect('/profile-setting', ['controller' => 'Users', 'action' => 'profileSetting']);
//    $routes->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
//
//    $routes->connect('/add-branch-admin', ['controller' => 'Users', 'action' => 'addBranchAdmin']);
//    $routes->connect('/branch-admin-listing', ['controller' => 'Users', 'action' => 'branchAdminListing']);
//
//    $routes->connect('/view-merchants/:id', ['controller' => 'Users', 'action' => 'viewMerchants', 'pass' => ['id']]);
//    $routes->connect('/view-customers/:id', ['controller' => 'Users', 'action' => 'viewCustomers', 'pass' => ['id']]);
//
//    $routes->connect('/transactions', ['controller' => 'Users', 'action' => 'transactions']);

    $routes->fallbacks('DashedRoute');
});

Router::prefix('branchadmin', function ($routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

//    $routes->connect('/profile-setting', ['controller' => 'Users', 'action' => 'profileSetting']);
//    $routes->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
//
//    $routes->connect('/view-merchants/:id', ['controller' => 'Users', 'action' => 'viewMerchants', 'pass' => ['id']]);
//    $routes->connect('/view-customers/:id', ['controller' => 'Users', 'action' => 'viewCustomers', 'pass' => ['id']]);

    $routes->fallbacks('DashedRoute');
});

Router::prefix('merchant', function ($routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

//    $routes->connect('/profile-setting', ['controller' => 'Users', 'action' => 'profileSetting']);
//    $routes->connect('/bank-details', ['controller' => 'Users', 'action' => 'bankDetails']);
//    $routes->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
//
//    $routes->connect('/customer-groups', ['controller' => 'Customers', 'action' => 'customerGroups']);
//    $routes->connect('/add-group', ['controller' => 'Customers', 'action' => 'addGroup']);
//    $routes->connect('/import-customers', ['controller' => 'Customers', 'action' => 'importCustomers']);
//    $routes->connect('/my-customers', ['controller' => 'Customers', 'action' => 'myCustomers']);
//    $routes->connect('/add-customer', ['controller' => 'Customers', 'action' => 'addCustomer']);
//    $routes->connect('/payment-setting', ['controller' => 'Customers', 'action' => 'paymentSetting']);
    // All routes here will be prefixed with `/merchant`
    // And have the prefix => merchant route element added.
    $routes->fallbacks('DashedRoute');
});

Router::prefix('customer', function ($routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'dashboard']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

    $routes->connect('/pay-now/*', ['controller' => 'Payments', 'action' => 'payNow']);
    $routes->connect('/view-transactions/*', ['controller' => 'Payments', 'action' => 'viewTransactions']);

//    $routes->connect('/profile-setting', ['controller' => 'Users', 'action' => 'profileSetting']);
//    $routes->connect('/change-password', ['controller' => 'Users', 'action' => 'changePassword']);
//    $routes->connect('/payment-and-bills', ['controller' => 'Users', 'action' => 'paymentAndBills']);
//    $routes->connect('/payment-history', ['controller' => 'Users', 'action' => 'paymentHistory']);
//    $routes->connect('/pay-now', ['controller' => 'Users', 'action' => 'payNow']);

    $routes->fallbacks('DashedRoute');
});

Router::scope('/', function (RouteBuilder $routes) {

    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
    $routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

    $routes->fallbacks('DashedRoute');
});

Plugin::routes();
