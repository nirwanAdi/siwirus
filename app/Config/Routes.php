<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'User::index');
$routes->get('/admin', 'Admin::index', ['filter'=>'role:admin'] );
$routes->get('/admin/index', 'Admin::index', ['filter'=>'role:admin'] );
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter'=>'role:admin'] );
$routes->get('/preorder', 'Preorder::index', ['filter'=>'role:admin'] );
$routes->get('/preorder/index', 'Preorder::index', ['filter'=>'role:admin'] );
$routes->get('/preorder/create', 'Preorder::create', ['filter'=>'role:admin'] );
$routes->get('/preorder/edit/(:segment)', 'Preorder::edit/$1', ['filter'=>'role:admin'] );
$routes->get('/preorder/metode-pembayaran/edit/(:segment)', 'MetodePembayaran::edit/$1', ['filter'=>'role:admin'] );
$routes->get('/preorder/metode-pembayaran/index', 'MetodePembayaran::index', ['filter'=>'role:admin'] );
$routes->get('/preorder/metode-pembayaran/create', 'MetodePembayaran::create', ['filter'=>'role:admin'] );
$routes->get('/preorder/transaksi-pre-order/index', 'TransaksiPreOrder::index', ['filter'=>'role:admin'] );
$routes->get('/preorder/transaksi-pre-order/detail/(:num)', 'TransaksiPreOrder::detail/$1', ['filter'=>'role:admin'] );
$routes->get('/etalase/index', 'Etalase::index', ['filter'=>'role:user'] );
$routes->get('/etalase/transaksi', 'Etalase::transaksi', ['filter'=>'role:user'] );
$routes->get('/etalase/beli/(:num)', 'Etalase::beli/$1', ['filter'=>'role:user'] );
$routes->get('/etalase/detail_transaksi/(:num)', 'Etalase::detail_transaksi/$1', ['filter'=>'role:user'] );
$routes->delete('/etalase/(:num)', 'Etalase::delete/$1', ['filter'=>'role:user'] );
$routes->delete('/etalase/hapus/(:num)', 'Etalase::hapus/$1', ['filter'=>'role:user'] );
$routes->delete('/transaksipreorder/(:num)', 'TransaksiPreOrder::delete/$1', ['filter'=>'role:admin'] );
$routes->delete('/preorder/(:num)', 'Preorder::delete/$1', ['filter'=>'role:admin'] );
$routes->delete('/metodepembayaran/(:num)', 'MetodePembayaran::delete/$1', ['filter'=>'role:admin'] );
$routes->get('/preorder/(:any)', 'Preorder::detail/$1', ['filter'=>'role:admin'] );
$routes->get('/kategori/index', 'Kategori::index', ['filter'=>'role:admin'] );
$routes->delete('/kategori/(:num)', 'Kategori::delete/$1', ['filter'=>'role:admin'] );
$routes->get('/satuan/index', 'Satuan::index', ['filter'=>'role:admin'] );
$routes->delete('/satuan/(:num)', 'Satuan::delete/$1', ['filter'=>'role:admin'] );
$routes->get('/toko/produk/index', 'Produk::index', ['filter'=>'role:admin'] );
$routes->get('/toko/produk/create', 'Produk::create', ['filter'=>'role:admin'] );
$routes->get('/toko/produk/edit/(:num)', 'Produk::edit/$1', ['filter'=>'role:admin'] );
$routes->delete('/produk/(:num)', 'Produk::delete/$1', ['filter'=>'role:admin'] );

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
