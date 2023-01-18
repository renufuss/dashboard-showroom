<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
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
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->get('/mobil', 'Car::index');
$routes->post('/mobil/getcar', 'Car::getCar');
$routes->post('/mobil/alertDelete', 'Car::alertCarDelete');
$routes->post('/mobil/delete', 'Car::deleteCar');
$routes->get('/mobil/(:num)', 'Car::detail/$1');
$routes->get('/mobil/(:num)/general', 'Car::pageEditGeneralCar/$1');
$routes->get('/mobil/(:num)/print', 'Car::printDetail/$1');

$routes->post('/mobil/download/additionalreceipt', 'Car::downloadAdditionalReceipt');

$routes->get('/mobil/tambah', 'Car::pageSetCar');
$routes->post('/mobil/tambah/temp/save', 'Car::setTempAdditionalCost');
$routes->post('/mobil/tambah/temp', 'Car::getTempAdditionalCost');
$routes->post('/mobil/save', 'Car::setCar');
$routes->post('/mobil/tambah/temp/download/additionalreceipt', 'Car::downloadTempAdditionalReceipt');
$routes->post('/mobil/tambah/temp/totalAdditionalCost', 'Car::getTotalTempAdditionalCost');
$routes->post('/mobil/tambah/temp/alertTempDelete', 'Car::alertTempAdditionalCostDelete');
$routes->post('/mobil/tambah/temp/delete', 'Car::deleteTempAdditionalCost');
$routes->post('/mobil/tambah/temp/reset', 'Car::resetTempAdditionalCost');

$routes->get('/penjualan', 'Sales::index');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
