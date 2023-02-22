<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    include SYSTEMPATH . 'Config/Routes.php';
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

$routes->get('/mobil', 'Car::index', );
$routes->post('/mobil/getcar', 'Car::getCar');
$routes->post('/mobil/alertDelete', 'Car::alertCarDelete', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/delete', 'Car::deleteCar', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/mobil/(:num)', 'Car::detail/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/mobil/(:num)/umum', 'Car::pageEditGeneralCar/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/mobil/(:num)/biaya', 'Car::pageEditAdditionalCost/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/(:num)/biaya', 'Car::getAdditionalCost/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/mobil/(:num)/print', 'Car::printDetail/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/biaya/modal', 'Car::additionalCostModal', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/biaya/(:num)', 'Car::setAdditionalCost/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/biaya/(:num)/(:num)', 'Car::setAdditionalCost/$1/$2', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/mobil/biaya/(:num)/(:num)/alertDelete', 'Car::alertAdditionalCostDelete/$1/$2', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/biaya/delete', 'Car::deleteAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);

$routes->post('/mobil/download/additionalreceipt', 'Car::downloadAdditionalReceipt', ['filter' => 'role:Super Admin, Keuangan']);

$routes->get('/mobil/tambah', 'Car::pageSetCar', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/save', 'Car::setTempAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp', 'Car::getTempAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/save', 'Car::setCar', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/download/additionalreceipt', 'Car::downloadTempAdditionalReceipt', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/totalAdditionalCost', 'Car::getTotalTempAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/alertTempDelete', 'Car::alertTempAdditionalCostDelete', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/delete', 'Car::deleteTempAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/mobil/tambah/temp/reset', 'Car::resetTempAdditionalCost', ['filter' => 'role:Super Admin, Keuangan']);

$routes->get('/penjualan', 'Sales::index', ['filter' => 'role:Super Admin, Admin']);
$routes->get('/penjualan/table', 'Sales::salesTable', ['filter' => 'role:Super Admin, Admin']);
$routes->get('/penjualan/tempPrice', 'Sales::getTotalTempPrice', ['filter' => 'role:Super Admin, Admin']);
$routes->get('/penjualan/reset', 'Sales::resetTemp', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/car', 'Sales::carModal', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/alertDeleteTemp', 'Sales::alertDeleteTemp', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/deleteTemp', 'Sales::deleteTemp', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/saveTemp', 'Sales::saveTemp', ['filter' => 'role:Super Admin, Admin']);
$routes->get('/penjualan/payment', 'Sales::paymentModal', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/payment', 'Sales::savePayment', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/payment/discount', 'Sales::setDiscount', ['filter' => 'role:Super Admin, Admin']);
$routes->post('/penjualan/payment/over', 'Sales::setOver', ['filter' => 'role:Super Admin, Admin']);

$routes->get('/penjualan/riwayat', 'Sales::pageSalesHistory');
$routes->post('/penjualan/riwayat', 'Sales::getSalesHistory');
$routes->get('/penjualan/riwayat/(:alphanum)', 'Sales::pageSalesHistoryDetail/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->get('/penjualan/riwayat/(:alphanum)/pembayaran', 'Sales::pageSalesHistoryPayment/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/penjualan/riwayat/(:alphanum)/pembayaran/add', 'Sales::addPaymentModal/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/penjualan/riwayat/(:alphanum)/pembayaran', 'Sales::addPayment/$1', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/penjualan/riwayat/(:alphanum)/paymentReceipt', 'Sales::downloadPaymentReceipt/$1', ['filter' => 'role:Super Admin, Keuangan']);


$routes->get('/transaksi', 'Transaction::index', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/transaksi', 'Transaction::getTransaction', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/transaksi/total', 'Transaction::getTotalTransaction', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/transaksi/modal', 'Transaction::openTransactionModal', ['filter' => 'role:Super Admin, Keuangan']);
$routes->post('/transaksi/save', 'Transaction::saveTransaction', ['filter' => 'role:Super Admin, Keuangan']);

$routes->get('/pengguna', 'User::index', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/table', 'User::showTable', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/save', 'User::save', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/confirm', 'User::confirmDelete', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/delete', 'User::deleteUser', ['filter' => 'role:Super Admin']);
$routes->get('/pengguna/detail/(:alphanum)', 'User::pageDetailProfile/$1', ['filter' => 'role:Super Admin']);
$routes->get('/pengguna/setting/(:alphanum)', 'User::pageSettingProfile/$1', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/setting/(:alphanum)', 'User::updateProfile/$1', ['filter' => 'role:Super Admin']);
$routes->post('/pengguna/setting/(:alphanum)/password', 'User::changePassword/$1', ['filter' => 'role:Super Admin']);

$routes->get('/profile', 'User::pageDetailProfile');
$routes->get('/profile/setting', 'User::pageSettingProfile');
$routes->post('/profile/setting', 'User::updateProfile');
$routes->post('/profile/setting/password', 'User::changePassword');


$routes->get('/laporan', 'Report::index', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/profitTable', 'Report::profitTable', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/refundTable', 'Report::refundTable', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/generalIncomeTable', 'Report::generalIncomeTable', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/generalOutcomeTable', 'Report::generalOutcomeTable', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/calculation', 'Report::getCalculation', ['filter' => 'role:Super Admin']);
$routes->get('/laporan/calculation', 'Report::getCalculation', ['filter' => 'role:Super Admin']);
$routes->post('/laporan/claim', 'Report::claimTransaction', ['filter' => 'role:Super Admin']);





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
    include APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
