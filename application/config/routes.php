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
|	http://codeigniter.com/user_guide/general/routing.html
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

switch ($_SERVER['HTTP_HOST']) {
    case 'localhost':
        $route['default_controller']             = 'auth';
        break;
    default:
        $route['default_controller']             = 'home';
        break;
}

/* Auth User */
$route['users']			 				= 'auth';
$route['user/create'] 					= 'auth/create_user';
$route['user/read/(:num)'] 				= 'auth/read_user/$1';
$route['user/edit/(:num)'] 				= 'auth/edit_user/$1';
$route['user/delete/(:num)']			= 'auth/delete_user/$1';
$route['user/activate/(:any)']		 	= 'auth/activate/$1';
$route['user/deactivate/(:any)'] 		= 'auth/deactivate/$1';

/* groups */
$route['groups']			 			= 'auth/group_list';
$route['group/create']  				= 'auth/create_group';
$route['group/edit/(:num)'] 			= 'auth/edit_group/$1';
$route['group/read/(:num)'] 			= 'auth/read_group/$1';
$route['group/delete/(:num)'] 			= 'auth/read_group/$1';

$route['deactivate/(:num)'] 			= 'auth/deactivate/$1';
$route['activate/(:num)'] 				= 'auth/activate/$1';
$route['login'] 						= 'auth/login';
$route['logout'] 						= 'auth/logout';

$route['activation']                    = 'auth/activation';
$route['registration']                  = 'auth/register';
$route['cancel'] 			            = 'auth/clear';
$route['generate/(:num)'] 		        = 'auth/generate/$1';
$route['activation/user/(:num)/(:any)'] = 'auth/activation_user/$1/$2';

// $route['edit-password'] 		= 'auth/edit_password';
// $route['forgot-password'] 	= 'auth/forgot_password';

/* menu */
$route['menu/create']					= 'menu/create_menu';
$route['menu/read/(:num)']				= 'menu/read_menu/$1';
$route['menu/update/(:num)']			= 'menu/update_menu/$1';
$route['menu/delete/(:num)']			= 'menu/delete_menu/$1';

$route['404_override']			 		= '';
$route['translate_uri_dashes']	 		= FALSE;
