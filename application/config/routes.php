<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'AuthController';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/*
| -------------------------------------------------------------------------
| AUTHENTICATION
| -------------------------------------------------------------------------
*/
$route['login']['GET']									= 'AuthController/login';
$route['auth/login']['POST']							= 'AuthController/post_login';
$route['logout']['GET']									= 'AuthController/logout';

/*
| -------------------------------------------------------------------------
| ADMIN ROUTES
| -------------------------------------------------------------------------
*/
$route['admin/(:any)']['GET']							= 'AdminController/admin_page/$1';
// ORGANIZATION
$route['organization/create']['POST']					= 'AdminController/create_organization';
$route['admin/organization/(:num)/edit']['GET']			= 'AdminController/edit_organization/$1';
$route['organization/update']['POST']					= 'AdminController/update_organization';
// USER
$route['user/create']['POST']							= 'AdminController/create_user';
$route['admin/user/(:num)/edit']['GET']					= 'AdminController/edit_user/$1';
$route['user/update']['POST']							= 'AdminController/update_user';
// COURSE
$route['course/create']['POST']							= 'AdminController/create_course';
$route['admin/course/(:num)/edit']['GET']				= 'AdminController/edit_course/$1';
$route['course/update']['POST']							= 'AdminController/update_course';

// ANGULARJS API ROUTES
$route['api/user/delete']['POST']						= 'AdminController/delete_user';
$route['api/course/delete']['POST']						= 'AdminController/delete_course';
$route['api/organization/delete']['POST']				= 'AdminController/delete_organization';
$route['api/area/delete']['POST']						= 'UsersController/delete_area';

/*
| -------------------------------------------------------------------------
| USER ROUTES
| -------------------------------------------------------------------------
*/
// USER
$route['user/(:any)']['GET']							= 'UsersController/user_page/$1';
$route['user/user/create']['POST']						= 'UsersController/create_user';
$route['user/(:num)/edit']['GET']						= 'UsersController/edit_user/$1';
$route['user/user/update']['POST']						= 'UsersController/update_user';
// AREA
$route['area/create']['POST']							= 'UsersController/create_area';
$route['user/area/(:num)']['GET']						= 'UsersController/edit_area/$1';
$route['area/update']['POST']							= 'UsersController/update_area';
// TEMPLATE
$route['user/area/(:num)/(:any)']['GET']				= 'UsersController/area_view/$1/$2';
// UPLOADS
$route['user/area/(:num)/parameter/(:num)']['GET']		= 'UsersController/area_view_entries/$1/$2';
$route['user/file_upload/(:num)']['POST']				= 'UsersController/file_upload/$1';

// UPLOADS
// SEARCH FOR RELATED FILES
$route['api/search_for_file']['POST']					= 'UsersController/search_file';
// -------CREATE GET FUNCTION FOR UPLOADS
$route['api/get_uploads/(:num)']['GET']					= 'UsersController/get_uploads/$1';

// Parameters
$route['api/create/parameter']['POST']					= 'UsersController/create_param';
$route['api/get/parameters/(:num)']['GET']				= 'UsersController/get_parameters/$1';
$route['api/get/clean_parameters/(:num)']['GET']		= 'UsersController/get_parameters_clean/$1';
$route['api/edit/parameter/(:num)']['GET']				= 'UsersController/get_parameters_by_id/$1';
$route['api/update/parameter']['POST']					= 'UsersController/update_parameter';
$route['api/delete/parameter']['POST']					= 'UsersController/delete_parameter';