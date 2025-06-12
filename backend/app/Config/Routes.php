<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');
$routes->get('/user', 'User::index');
$routes->post('/user/login', 'User::login');

// Tambahkan ini di bawah semua route:
$routes->options('(:any)', function() {
    return service('response')
        ->setHeader('Access-Control-Allow-Origin', 'http://10.11.12.13:3000') // Atau ganti sesuai domain frontend kamu
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization')
        ->setStatusCode(200);
});
