<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Domů
$routes->get('/', 'Home::index');

// Galerie a úspěšné adopce
$routes->get('/gallery', 'Gallery::index');
$routes->get('/success', 'Success::index');

// Správa koček
$routes->group('manage', function (RouteCollection $routes) {
    $routes->get('', 'Manage::index');
    $routes->get('add', 'Manage::add');
    $routes->post('add', 'Manage::add');
    $routes->get('edit/(:num)', 'Manage::edit/$1');
    $routes->post('edit/(:num)', 'Manage::edit/$1');
    $routes->get('soft-delete/(:num)', 'Manage::softDelete/$1');
    $routes->get('adopt/(:num)', 'Manage::adopt/$1');
});

// Správa uživatelů
$routes->group('admin/users', function (RouteCollection $routes) {
    $routes->get('', 'AdminUsers::index');
    $routes->get('add', 'AdminUsers::add');
    $routes->post('add', 'AdminUsers::add');
    $routes->get('edit/(:num)', 'AdminUsers::edit/$1');
    $routes->post('edit/(:num)', 'AdminUsers::edit/$1');
    $routes->get('soft-delete/(:num)', 'AdminUsers::softDelete/$1');
    $routes->get('restore/(:num)', 'AdminUsers::restore/$1');
});

// Fallback pro chyby 404
$routes->set404Override();


