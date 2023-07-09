<?php

use Config\Services;

$routes = Services::routes();

$routes->get('login', 'User::login', ['filter' => 'TidakLogin']);
$routes->post('login', 'User::login_post', ['filter' => 'TidakLogin']);
$routes->get('register', 'User::register', ['filter' => 'TidakLogin']);
$routes->post('register', 'User::register_post', ['filter' => 'TidakLogin']);

$routes->get('logout', 'User::logout', ['filter' => 'HarusLogin']);