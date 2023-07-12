<?php

use Config\Services;

$routes = Services::routes();

$routes->post('upload/gambar', 'Uploader::gambar');

$routes->get('login', 'User::login', ['filter' => 'TidakLogin']);
$routes->post('login', 'User::login_post', ['filter' => 'TidakLogin']);
$routes->get('register', 'User::register', ['filter' => 'TidakLogin']);
$routes->post('register', 'User::register_post', ['filter' => 'TidakLogin']);
$routes->get('logout', 'User::logout', ['filter' => 'HarusLogin']);

// 
$routes->get('dashboard', 'Home::dashboard', ['filter' => 'HarusLogin']);
$routes->get('barang', 'Barang::list', ['filter' => 'HarusLogin']);
$routes->get('barang/tambah', 'Barang::tambah', ['filter' => 'HarusLogin']);
$routes->post('barang/tambah', 'Barang::post_tambah', ['filter' => 'HarusLogin']);