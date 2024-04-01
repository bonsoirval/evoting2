<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Pages;
use App\Controllers\News; // add this line
use App\Controllers\Admin; // add this line

/**
 * @var RouteCollection $routes
 */
/** Admin Routes Start */
$routes->get('h_admin/update_party', 'Admin\Admins::update_party');
$routes->post('h_admin/update_party', 'Admin\Admins::update_party');
$routes->get('h_admin/manage_party', 'Admin\Admins::manage_party'); 
$routes->post('h_admin/manage_party', 'Admin\Admins::manage_party');
$routes->get('h_admin/add_party', 'Admin\Admins::add_party', ['as' => 'add_party']);
$routes->post('h_admin/add_party', 'Admin\Admins::add_party', ['as' => 'add_party_post']);
$routes->get('h_admin/signout', 'Admin\Admins::signout', ['as' => 'signout']);
$routes->get('h_admin', 'Admin\Admins::index', ['as' => 'admin_login']);
$routes->get('h_admin/index', 'Admin\Admins::index');

$routes->post('h_admin/index', 'Admin\Admins::index');
/** Admin Routes End */


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