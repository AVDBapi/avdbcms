<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

// $route['default_controller'] = 'welcome';
// $route['404_override'] = '';
// $route['translate_uri_dashes'] = FALSE;

// $route['^(en|ar)/contact'] = "pages/contact";
// $route['^(en|ar)/privacy-policy$'] = "pages/index/privacy_policy";
// $route['^(en|ar)/terms-of-use$'] = "pages/index/terms_of_use";
// // example: '/en/about' -> use controller 'about'
// $route['^en/(.+)$'] = "$1";
// $route['^ar/(.+)$'] = "$1";
// $route['^bn/(.+)$'] = "$1";
// // '/en' and '/ar' -> use default controller
// $route['^(en|ar|bn)$'] = $route['default_controller'];




// default language routes


$route['watch/(:any)'] 					= 'watch/index/$1';
$route['watch/(:any)/(:any)'] 			= 'watch/index/$1/$2';
$route['watch/(:any)/(:any)/(:any)'] 	= 'watch/index/$1/$2/$3';
$route['blog/:num'] 					= 'blog/index';
$route['blog/category/(:any)'] 			= 'blog/category/$1';
$route['blog/(:any)'] 					= 'blog/details/$1';
$route['country/(:any)'] 				= 'country/index/$1';
$route['country/(:any)/:num'] 			= 'country/index/$1';
$route['genre/(:any)'] 					= 'genre/index/$1';
$route['genre/(:any)/:num'] 			= 'genre/index/$1';
$route['type/(:any)'] 					= 'type/index/$1';
$route['type/(:any)/:num'] 				= 'type/index/$1';
$route['request-movies'] 				= 'home/request_movies';
$route['contact-us'] 					= 'home/contact';
$route['send_message'] 					= 'home/send_message';
$route['contact_process'] 				= 'home/contact_process';
$route['send_movie_request'] 			= 'home/send_movie_request';
$route['search'] 						= 'home/search';
$route['filter_movies'] 				= 'home/filter_movies';
$route['filter_movies/(:any)'] 			= 'home/filter_movies';
$route['movies'] 						= 'home/movies';
$route['movie/(:any)'] 					= 'movie/index/$1';
$route['all-movies'] 					= 'home/home2';
$route['filter_tvseries'] 				= 'home/filter_tvseries';
$route['filter_tvseries/(:any)'] 		= 'home/filter_tvseries';
$route['tv-series'] 					= 'tvseries/home';
$route['tv-series/watch'] 				= 'tvseries/watch';
$route['tv-series/watch/(:any)'] 		= 'tvseries/watch/$1';
$route['live-tv'] 						= 'live_tv/index/$1';
$route['live-tv/category'] 				= 'live_tv/category/$1';
$route['live-tv/category/(:any)'] 		= 'live_tv/category/$1';
$route['live-tv/(:any)'] 				= 'live_tv/watch/$1';
$route['about-us'] 						= 'page/about_us';
$route['request-movies'] 				= 'home/request_movies';
$route['privacy-policy'] 				= 'home/policy';
$route['trailers'] 						= 'home/trailers';
$route['request'] 						= 'home/request_for_movies';
$route['dmca'] 							= 'home/dmca';
$route['policy'] 						= 'home/policy';
$route['terms'] 						= 'home/terms';
$route['star'] 							= 'star/index';
$route['star/:num']						= 'star/index';
$route['star/(:any)'] 					= 'star/movie_by_star/$1';
$route['star/(:any)/:num'] 					= 'star/movie_by_star/$1/$2';
$route['director/(:any)'] 				= 'director/index/$1';
$route['director/(:any)/:num'] 			= 'director/index/$1';
$route['tags/(:any)'] 					= 'tags/index/$1';
$route['tags/(:any)/:num'] 				= 'tags/index/$1';
$route['year'] 							= 'year/find';
$route['year/(:any)'] 					= 'year/find/$1';
$route['year/(:any)/:num'] 				= 'year/find/$1';
$route['page/(:any)'] 					= 'page/index/$1';
$route['my-account/profile'] 			= 'user/profile';
$route['my-account/update'] 			= 'user/update_profile';
$route['my-account/favorite'] 			= 'user/favorite';
$route['my-account/change-password'] 	= 'user/change_password';
$route['my-account/watch-later'] 		= 'user/watch_later';
$route['my-account/subscription'] 		= 'user/subscription';

$route['az-list'] 						= 'az/index';
$route['az-list/(:any)/page/(:any)'] 	= 'az/index/$1';
$route['az-list/(:any)'] 				= 'az/index/$1';
$route['az-list/(:any)/(:any)'] 		= 'az/index/$1';






$route['rest-api'] 										= 'admin/api_test';
$route['rest-api/v100'] 								= 'admin/api_test';

// api v100
$route['rest-api/v100/(:any)'] 							= 'rest_api/v100/$1';
$route['rest-api/v100/(:any)/(:any)'] 					= 'rest_api/v100/$1/$2';
$route['rest-api/v100/(:any)/(:any)/(:any)'] 			= 'rest_api/v100/$1/$2/$3';
$route['rest-api/v100/(:any)/(:any)/(:any)/(:any)'] 	= 'rest_api/v100/$1/$2/$3/$4';

//  api v130
$route['rest-api/v130/(:any)'] 							= 'rest_api/v130/$1';
$route['rest-api/v130/(:any)/(:any)'] 					= 'rest_api/v130/$1/$2';
$route['rest-api/v130/(:any)/(:any)/(:any)'] 			= 'rest_api/v130/$1/$2/$3';
$route['rest-api/v130/(:any)/(:any)/(:any)/(:any)'] 	= 'rest_api/v130/$1/$2/$3/$4';

// legacu api
$route['api'] 											= 'legacy_api/index';
$route['api/(:any)'] 									= 'legacy_api/$1';


// default routes
$route['default_controller'] 			= "home";
$route['404_override'] 					= 'notfound';
$route['translate_uri_dashes'] 			= FALSE;











// // translate routes
// $route['^en/(.+)$'] = "$1";
// $route['^ar/(.+)$'] = "$1";
// $route['^bn/(.+)$'] = "$1";
// $route['^(en|ar|bn)$'] = $route['default_controller'];


/* End of file routes.php */
/* Location: ./application/config/routes.php */