<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/gallery', 'Gallery::index');
$routes->get('/manage', 'Manage::index');
$routes->post('/manage/add', 'Manage::add');
$routes->get('/manage/edit/(:num)', 'Manage::edit/$1');
$routes->post('/manage/update/(:num)', 'Manage::update/$1');
$routes->get('/manage/delete/(:num)', 'Manage::delete/$1');
