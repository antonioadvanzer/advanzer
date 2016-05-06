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
$route['default_controller'] = 'main';
$route['login'] = 'main/login';
$route['logout'] = 'main/logout';
$route['auth'] = 'main/login';
$route['administrar_usuarios'] = 'user';
$route['administrar_usuarios/(:num)'] = 'user/index/(:num)';
$route['nuevo_usuario'] = 'user/nuevo';
$route['evaluaciones'] = 'evaluacion/evaluaciones';
$route['evaluaciones/(:num)'] = 'evaluacion/evaluaciones/(:num)';
$route['administrar_dominios'] = 'dominio';
$route['administrar_dominios/(:num)'] = 'dominio/index/(:num)';
$route['evaluadores360'] = 'evaluacion/evaluadores360';
$route['evaluadores360/(:num)'] = 'evaluacion/evaluadores360/(:num)';
$route['carga_comp_resp'] = 'masiva/carga_comp_resp';
$route['administrar_indicadores'] = 'indicador';
//$route['evaluaciones'] = 'evaluacion';
$route['evaluacion/(:num)'] = 'evaluacion/index/(:num)';
$route['evaluar'] = 'evaluacion/evaluar';
$route['historial'] = 'main/historial';
$route['requisiciones'] = 'requisicion/index/true';
$route['vacaciones'] = 'servicio/vacaciones';
$route['admin_solicitudes'] = 'main/solicitudes';
$route['solicitar_vacaciones'] = 'servicio/formato_vacaciones';
$route['solicitudes'] = 'servicio/solicitudes';
$route['solicitudes_pendientes'] = 'servicio/solicitudes_pendientes';
$route['permiso'] = 'servicio/permiso';
$route['solicitar_permiso'] = 'servicio/formato_permiso';
$route['viaticos_gastos'] = 'servicio/viaticos_gastos';
$route['solicitar_viaticos_gastos'] = 'servicio/formato_viaticos_gastos';
$route['comprobar_gastos'] = 'servicio/formato_comprobacion';
/*
$route['estructura_organizacional'] = 'info/estructura';
$route['cartas_constancias'] = 'info/cartas_constancias';
$route['sap'] = 'info/certificacion_sap';
$route['viaticos'] = 'info/viaticos_gastos';
$route['vacaciones'] = 'info/vacaciones';
$route['permisos'] = 'info/permisos';
$route['vestimenta'] = 'info/vestimenta';*/
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
