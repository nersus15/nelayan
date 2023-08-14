<?php

use Config\Services;

$routes = Services::routes();

$routes->post('upload/gambar', 'Uploader::gambar');

$routes->get('login', 'User::login', ['filter' => 'TidakLogin']);
$routes->post('login', 'User::login_post', ['filter' => 'TidakLogin']);
$routes->get('register', 'User::register', ['filter' => 'TidakLogin']);
$routes->post('register', 'User::register_post', ['filter' => 'TidakLogin']);
$routes->get('logout', 'User::logout', ['filter' => 'HarusLogin']);
$routes->get('profile', 'User::profile', ['filter' => 'HarusLogin']);
$routes->post('profile/update', 'User::update_profile', ['filter' => 'HarusLogin']);

$routes->get('keranjang', 'User::keranjang');
$routes->post('pesan', 'User::pesan');
$routes->get('tracking', 'User::tracking');
$routes->get('track/(:any)', 'User::track/$1');
$routes->get('info/(:any)', 'User::info/$1');

// 
$routes->get('dashboard', 'Home::dashboard', ['filter' => 'HarusLogin']);
$routes->get('barang/masuk', 'Barang::list', ['filter' => 'HarusLogin']);
$routes->get('barang/keluar', 'Barang::keluar', ['filter' => 'HarusLogin']);
$routes->get('barang/info/(:any)', 'Barang::info/$1', ['filter' => 'HarusLogin']);
$routes->get('barang/tambah', 'Barang::tambah', ['filter' => 'HarusLogin']);
$routes->get('barang/update/(:any)', 'Barang::update/$1', ['filter' => 'HarusLogin']);
$routes->get('barang/delete/(:any)', 'Barang::delete/$1', ['filter' => 'HarusLogin']);
$routes->post('barang/tambah', 'Barang::post_tambah', ['filter' => 'HarusLogin']);

$routes->get('penjualan', 'User::penjualan', ['filter' => 'HarusLogin']);
$routes->post('tolak', 'User::tolak', ['filter' => 'HarusLogin']);
$routes->get('terima/(:any)', 'User::terima/$1', ['filter' => 'HarusLogin']);
$routes->get('selesai/(:any)', 'User::selesai/$1', ['filter' => 'HarusLogin']);

$routes->get('nelayan', 'Nelayan::index', ['filter' => 'HarusLogin']);
$routes->post('nelayan/data/(:any)', 'Nelayan::find/$1', ['filter' => 'HarusLogin']);
$routes->post('nelayan/save', 'Nelayan::save', ['filter' => 'HarusLogin']);
$routes->get('nelayan/hapus/(:any)', 'Nelayan::hapus/$1', ['filter' => 'HarusLogin']);

$routes->get('bayar/(:any)', 'User::bayar/$1');
$routes->get('bayar', 'User::bayar');
