<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News; // add this line

/**
 * @var RouteCollection $routes
 */
$routes->get('logout', 'Voters::logout');

$routes->post('result', 'Results::index');
$routes->get('result', 'Results::index');
$routes->get('vote_successful',  'Voters::vote_successful');
$routes->post('vote', 'Voters::vote');
$routes->get('voting', 'Voters::voter_dashboard');
$routes->post('logout', 'Voters::logout');
$routes->get('login', 'Voters::login');
$routes->post('login', 'Voters::login');

$routes->post('register', 'Voters::register');
$routes->get('register','Voters::index');  // 'Voter::index'); 

//$routes->get('news',[News::class, 'index']);  // add this line
// $routes->get('news/new', [News::class, 'new']);
// $routes->post('news', [News::class,'create']);
// $routes->get('news/(:segment)', [News::class, 'show']); // add this line

$routes->get('/', 'Home::index');
// $routes->get('pages', [Pages::class, 'index']);
// $routes->get('(:segment)', [Pages::class, 'view']);