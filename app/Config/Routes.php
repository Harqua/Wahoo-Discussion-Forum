<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

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

#Home routes
$routes->get('/', 'Home::index');
$routes->get('/hello', 'Hello::index');

#Login/Logout routes
$routes->get('/login', 'Login::index');
$routes->get('/login/logout', 'Login::logout');
$routes->post('/login/check_login', 'Login::check_login');

#Register routes
$routes->get('/register', 'Register::register');
$routes->get('/register/login', 'Login::index');
$routes->post('/register/check_register', 'Register::check_register');
$routes->get('/register/activate/(:alpha)/(:num)/(:alphanum)', 'Register::activate');

#Forgot Password routes
$routes->get('/forgot_password', 'ForgotPassword::forgot_password');
$routes->post('/forgot_password/check_email', 'ForgotPassword::check_email');
$routes->post('/forgot_password/check_email/reset', 'ForgotPassword::reset_password');

#Dashboard routes
$routes->get('/dashboard', 'Dashboard::dashboard');
$routes->get('/dashboard/join', 'Dashboard::join_course');
$routes->get('/dashboard/create', 'Dashboard::create_course');
$routes->post('/dashboard/create/create_status', 'Dashboard::create_status');
$routes->get('/dashboard/join', 'Dashboard::join_course');
$routes->get('/dashboard/join/search', 'Dashboard::find_course');
$routes->get('/dashboard/edit-profile', 'Dashboard::edit_profile');
$routes->post('/dashboard/edit-profile/edit-check', 'Dashboard::edit_check');
$routes->get('/dashboard/liked-posts', 'Dashboard::like_list');
$routes->get('/dashboard/liked-posts/(:num)', 'Post::remove_like_bookmark');

#Post routes
$routes->get('/dashboard/course/(:num)', 'Post::course_index');
$routes->get('/dashboard/course/(:num)/create_post', 'Post::create_post');
$routes->post('/dashboard/course/(:num)/create_post/submit', 'Post::submit');
$routes->get('/dashboard/course/(:num)/like/(:num)', 'Post::like_post');

#Reply routes
$routes->get('/dashboard/course/(:num)/reply/(:num)', 'Reply::reply_index');
$routes->post('/dashboard/course/(:num)/reply/(:num)/submit-reply', 'Reply::submit_reply');
$routes->get('/dashboard/course/(:num)/reply/(:num)/endorse/(:num)', 'Reply::endorse_reply');
$routes->get('/dashboard/course/(:num)/reply/(:num)/unendorse/(:num)', 'Reply::endorse_reply');


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
