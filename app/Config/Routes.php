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
$routes->set404Override(function() {
	return view('404');
});
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
$routes->get('/test', 'Home::test');
$routes->get('/login', 'Home::login');
$routes->post('/login', 'Home::login');
$routes->get('/register', 'Home::register');
$routes->post('/register', 'Home::register');
$routes->get('/confirm_email', 'Home::confirm_email');
$routes->get('/logout', 'Home::logout');
$routes->get('/new_password', 'Home::new_password');
$routes->post('/new_password', 'Home::new_password');
$routes->post('/forgot_password', 'Home::forgot_password');

/*
 * --------------------------------------------------------------------
 * User Route
 * --------------------------------------------------------------------
 */

// $routes->get('/', 'User::view_race_result');
$routes->get('/user/events', 'User::events');
$routes->get('/events/request', 'User::event_request');
$routes->get('/events/view', 'User::event_page');
$routes->post('/events/view', 'User::event_page');
$routes->get('/user', 'User::index');
$routes->get('/logout', 'User::logout');
$routes->get('/user/profile', 'User::profile');
$routes->post('/user/update_profile', 'User::update_profile');
$routes->post('/user/update_machine', 'User::update_machine');
$routes->post('/user/update_password', 'User::update_password');
$routes->post('/user/update_email', 'User::update_email');
$routes->get('/user/save_new_email', 'User::save_new_email');
$routes->get('/user/scan', 'User::scan_qrcode');
$routes->post('/user/scan_image', 'User::scan_qrcode_image');
$routes->get('/user/reached', 'User::verify_location');
$routes->get('/user/mark_location', 'User::mark_location');
$routes->post('/user/live_location', 'User::live_location');
$routes->post('/user/accepted_for_today_event', 'User::accepted_for_today_event');
$routes->get('/user/turn_on_location', 'User::turn_on_location');

/*
 * --------------------------------------------------------------------
 * Organizer Route
 * --------------------------------------------------------------------
 */

// EVENTS


$routes->get('/organizer', 'Organizer::index');
$routes->get('/organizer/categories', 'Organizer::categories');
$routes->get('/organizer/get_categories', 'Organizer::get_categories');
$routes->post('/organizer/categories/add', 'Organizer::add_category');
$routes->post('/organizer/categories/update', 'Organizer::update_category');
$routes->post('/organizer/categories/delete', 'Organizer::delete_category');
$routes->post('/organizer/save_category', 'Organizer::add_category');


$routes->get('/organizer/events', 'Organizer::events');
$routes->get('/organizer/events/(:num)', 'Organizer::events/$1');
$routes->get('/organizer/events/add', 'Organizer::add_event');
$routes->post('/organizer/events/add', 'Organizer::save_event');
$routes->get('/organizer/events/delete', 'Organizer::delete_event');
$routes->get('/organizer/events/edit', 'Organizer::edit_event');
$routes->post('/organizer/events/update', 'Organizer::update_event');
$routes->get('/organizer/events/track/', 'Organizer::event_track');
$routes->get('/organizer/events/track/(:num)', 'Organizer::event_track/$1');
$routes->get('/organizer/events/(:num)/category/(:num)', 'Organizer::category_track/$1/$2');
$routes->get('/organizer/events/(:any)/user/(:any)/track/(:any)', 'Organizer::find_user/$1/$2/$3');
$routes->post('/organizer/start_event_track', 'Organizer::start_event_track');
$routes->post('/organizer/start_all_event_tracks', 'Organizer::start_all_event_tracks');
$routes->post('/organizer/end_all_event_tracks', 'Organizer::end_all_event_tracks');
$routes->post('/organizer/stop_event_track', 'Organizer::stop_event_track');
$routes->post('/organizer/delete_event_track', 'Organizer::delete_event_track');
$routes->post('/organizer/update_event_track', 'Organizer::update_event_track');
$routes->get('/organizer/events/orentance/(:num)', 'Organizer::orentance_track/$1');
$routes->get('/organizer/event_requests', 'Organizer::event_requests');
$routes->get('/organizer/event_requests/approve', 'Organizer::approve_event_request');
$routes->get('/organizer/generate_qr_code', 'Organizer::generate_qr_code');
$routes->get('/organizer/event_track_results', 'Organizer::event_track_results');
$routes->get('/organizer/get_event_track_results', 'Organizer::get_event_track_results');
$routes->get('/organizer/get_locations_reached', 'Organizer::get_locations_reached');
$routes->get('/organizer/get_events_of_locations_reached', 'Organizer::get_events_of_locations_reached');
$routes->post('/organizer/get_all_tracks', 'Organizer::get_all_tracks');
$routes->post('/organizer/save_track_event', 'Organizer::save_track_event');
$routes->post('/organizer/save_orientation_event', 'Organizer::save_orientation_event');
$routes->get('/organizer/get_all_orientation_events', 'Organizer::get_all_orientation_events');
$routes->get('/organizer/get_all_track_events', 'Organizer::get_all_track_events');
$routes->get('/organizer/category_results', 'Organizer::select_category_for_result');
$routes->get('/organizer/category_results/(:num)', 'Organizer::category_results/$1');
$routes->get('/organizer/delete_event', 'Organizer::delete_one_event');
$routes->get('/organizer/get_single_orientation_event', 'Organizer::get_single_orientation_event');
$routes->post('/organizer/update_event', 'Organizer::update_event');
$routes->get('/organizer/get_all_events', 'Organizer::get_all_events');
$routes->post('/organizer/add_classes_to_event', 'Organizer::add_classes_to_event');
$routes->get('/organizer/get_available_classes', 'Organizer::get_available_classes');
$routes->post('/organizer/approve_request', 'Organizer::approve_request');

$routes->get('/organizer/all_users', 'Organizer::all_users');
$routes->post('/organizer/add_user', 'Organizer::add_user');
$routes->post('/organizer/delete_user', 'Organizer::delete_user');
$routes->post('/organizer/update_user', 'Organizer::update_user');
// $routes->post('/organizer/find_user', 'Organizer::find_user');

// RACES
$routes->get('/organizer/races', 'Organizer::races');
$routes->get('/organizer/races/add', 'Organizer::add_race');
$routes->post('/organizer/races/add', 'Organizer::add_race');
$routes->get('/organizer/races/delete/(:num)', 'Organizer::delete_race/$1');
$routes->get('/organizer/races/edit/(:num)', 'Organizer::edit_race/$1');
$routes->post('/organizer/races/edit/(:num)', 'Organizer::edit_race/$1');

// EVENTS IN RACES
$routes->get('/organizer/races/(:num)', 'Organizer::view_race/$1');
// $routes->post('/organizer/races/2/orientation_event/save', 'Orgnaizer::');


// LOCATIONS
$routes->get('/organizer/locations', 'Organizer::locations');
$routes->get('/organizer/locations/reached', 'Organizer::locations_reached');
$routes->post('/organizer/locations/reached', 'Organizer::locations_reached');
$routes->post('/organizer/locations/save', 'Organizer::save_location');
$routes->get('/organizer/locations/delete', 'Organizer::delete_location');
$routes->get('/organizer/locations/edit', 'Organizer::edit_location');
$routes->post('/organizer/locations/update', 'Organizer::update_location');

// Tracks
$routes->get('/organizer/tracks', 'Organizer::tracks');
$routes->get('/organizer/get_live_locations', 'Organizer::get_live_locations');

// MAp
$routes->get('/organizer/map', 'Organizer::map');

/*
 * --------------------------------------------------------------------
 * Participant Route
 * --------------------------------------------------------------------
 */
// $routes->get('/participant', 'Participant::index');
// $routes->get('/participant/events', 'Participant::events');
// $routes->get('/participant/events/request', 'Participant::event_request');
// $routes->get('/participant/events/view', 'Participant::event_page');
// $routes->post('/participant/events/start', 'Participant::event_start');

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
