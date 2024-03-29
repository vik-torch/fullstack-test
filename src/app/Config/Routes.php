<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\CommentController;;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Home::index');

$routes->get('comments', [CommentController::class, 'index']);
$routes->post('comments', [CommentController::class, 'getCollect']);
$routes->post('comments/store', [CommentController::class, 'store']);
$routes->delete('comments/(:num)', [CommentController::class, 'delete/$1']);
