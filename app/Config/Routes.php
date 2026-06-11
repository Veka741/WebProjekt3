<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Veřejné stránky ──────────────────────────────────────────────────────────
$routes->get('/',        'Home::index');
$routes->get('/success', 'Success::index');

// ── Galerie fotek (veřejný výpis; přidání a mazání jen pro přihlášené) ────────
$routes->get('gallery',                   'Gallery::index');
$routes->get('gallery/detail/(:num)',     'Gallery::detail/$1');
// Routa se DVĚMA parametry: ID kočky + číslo stránky stránkování
$routes->get('gallery/cat/(:num)/(:num)', 'Gallery::byCat/$1/$2');
$routes->get('gallery/add',               'Gallery::add');
$routes->post('gallery/add',              'Gallery::add');
$routes->get('gallery/reserve/(:num)',    'Gallery::reserve/$1');
$routes->get('gallery/delete/(:num)',     'Gallery::delete/$1');

// ── Autentizace (vlastní přihlášení proti tabulce users) ─────────────────────
$routes->get( 'auth/login',           'Auth::login');
$routes->post('auth/login',           'Auth::login');
$routes->get( 'auth/logout',          'Auth::logout');
$routes->get( 'auth/forgot_password', 'Auth::forgot_password');

// ── Správa koček (chráněno AuthFilter – viz app/Config/Filters.php) ──────────
$routes->group('manage', function (RouteCollection $routes) {
    $routes->get('',                'Manage::index');
    $routes->get('detail/(:num)',   'Manage::detail/$1');
    $routes->get('add',             'Manage::add');
    $routes->post('add',            'Manage::add');
    $routes->get('edit/(:num)',     'Manage::edit/$1');
    $routes->post('edit/(:num)',    'Manage::edit/$1');
    $routes->get('soft-delete/(:num)', 'Manage::softDelete/$1');
    $routes->get('delete-photo/(:num)', 'Manage::deletePhoto/$1');
    $routes->get('adopt/(:num)',    'Manage::adopt/$1');
});

// ── Správa uživatelů (chráněno AuthFilter) ───────────────────────────────────
$routes->group('admin/users', function (RouteCollection $routes) {
    $routes->get('',                   'AdminUsers::index');
    $routes->get('add',                'AdminUsers::add');
    $routes->post('add',               'AdminUsers::add');
    $routes->get('edit/(:num)',        'AdminUsers::edit/$1');
    $routes->post('edit/(:num)',       'AdminUsers::edit/$1');
    $routes->get('soft-delete/(:num)', 'AdminUsers::softDelete/$1');
    $routes->get('restore/(:num)',     'AdminUsers::restore/$1');
});

// Fallback 404
$routes->set404Override();
