<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ── Veřejné stránky ──────────────────────────────────────────────────────────
$routes->get('/',        'Home::index');
$routes->get('/gallery', 'Gallery::index');
$routes->get('/success', 'Success::index');

// ── Autentizace (Ion Auth) ────────────────────────────────────────────────────
// Login / Logout – handled by our App\Controllers\Auth which extends Ion Auth
$routes->get( 'auth/login',  'Auth::login');
$routes->post('auth/login',  'Auth::login');
$routes->get( 'auth/logout', 'Auth::logout');

// Ion Auth optional extras (forgot/reset/change password)
$routes->get( 'auth/forgot_password',          'Auth::forgot_password');
$routes->post('auth/forgot_password',          'Auth::forgot_password');
$routes->get( 'auth/reset_password/(:segment)', 'Auth::reset_password/$1');
$routes->post('auth/reset_password/(:segment)', 'Auth::reset_password/$1');
$routes->get( 'auth/change_password',          'Auth::change_password');
$routes->post('auth/change_password',          'Auth::change_password');

// ── Správa koček (chráněno AuthFilter – viz app/Config/Filters.php) ──────────
$routes->group('manage', function (RouteCollection $routes) {
    $routes->get('',                'Manage::index');
    $routes->get('add',             'Manage::add');
    $routes->post('add',            'Manage::add');
    $routes->get('edit/(:num)',     'Manage::edit/$1');
    $routes->post('edit/(:num)',    'Manage::edit/$1');
    $routes->get('soft-delete/(:num)', 'Manage::softDelete/$1');
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
