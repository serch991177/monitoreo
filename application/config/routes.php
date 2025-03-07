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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['iniciar-sesion']                        = 'general/login/iniciar_sesion';
$route['cerrar-sesion']                         = 'general/login/logout';
$route['registro']                              = 'general/login/registro';
$route['bienvenido']                            = 'welcome';

/* MENU FUNCION */
$route['funciones']                             = 'admin/funcion';
$route['registrar-funcion']                     = 'admin/funcion/registrar';
$route['guardar-funcion']                       = 'admin/funcion/guardar';
$route['editar-funcion']                        = 'admin/funcion/editar';
$route['actualizar-funcion']                    = 'admin/funcion/actualizar';

/* MENU USUARIOS */
$route['usuarios']                              = 'admin/usuario';
$route['funciones-usuario/(:num)']              = 'admin/usuario/funciones/$1';
$route['cambiar-estado-funcion-usuario']        = 'admin/usuario/cambiar_estado';
$route['cambiar-rol']                           = 'admin/usuario/cambiar_rol';
$route['editar-usuario']                        = 'admin/usuario/editar';
$route['modificar-usuario']                     = 'admin/usuario/modificar';
$route['registrar-usuario']                     = 'admin/registro/index';
$route['guardar-usuario']                       = 'admin/registro/registro';

/* MENU FUNCIONES POR DEFECTO */
$route['por-defecto']                           = 'admin/defecto';
$route['cambiar-estado-por-defecto']            = 'admin/defecto/cambiar';
$route['registrar-por-defecto']                 = 'admin/defecto/registrar';
$route['guardar-funcion-defecto']               = 'admin/defecto/guardar';

/* MENU USUARIOS DESIGNADOS */
$route['dnis']                                  = 'admin/especial/index';
$route['cambiar-estado-dni']                    = 'admin/especial/cambiar';
$route['registrar-dni']                         = 'admin/especial/registrar';
$route['guardar-dni']                           = 'admin/especial/guardar';
$route['editar-especial']                       = 'admin/especial/editar';

/* MENU GESTION */
$route['gestiones']                             = 'admin/gestion/index';
$route['cambiar-estado-gestion']                = 'admin/gestion/cambiar';
$route['registrar-gestion']                     = 'admin/gestion/registrar';
$route['guardar-gestion']                       = 'admin/gestion/guardar';

/* MENU ROL */
$route['roles']                                 = 'admin/rol/index';
$route['cambiar-estado-rol']                    = 'admin/rol/cambiar';
$route['cambiar-estado-pregunta']               = 'sociales/pregunta/cambiar_estado';
$route['registrar-rol']                         = 'admin/rol/registrar';
$route['guardar-rol']                           = 'admin/rol/guardar';
$route['editar-rol']                            = 'admin/rol/editar';

/* MENU PERFIL */
$route['informacion']                           = 'general/perfil/informacion';
$route['mis-datos']                             = 'general/perfil/index';
$route['pagina-principal']                      = 'general/perfil/inicio';
$route['cambiar-contrasenia']                   = 'general/perfil/contrasenia';
$route['registrar-cambiar-contrasenia']         = 'general/perfil/registrarCambioContrasenia';

/* MONITOREO */
$route['dependencias']                          = 'normal/dependencia/lista';
$route['guardar-dependencia']                   = 'normal/dependencia/registrar';

$route['areas']                                 = 'normal/area/lista';
$route['guardar-area']                          = 'normal/area/registrar';
$route['guardar-area']                          = 'normal/area/registrar';

$route['medios']                                = 'normal/medio/lista';
$route['guardar-medio']                         = 'normal/medio/registrar';

$route['notas']                                 = 'normal/nota/lista';
$route['guardar-nota']                          = 'normal/nota/registrar';
$route['subir-archivo']                         = 'normal/nota/subir_archivo';
$route['asignar-medio']                         = 'normal/nota/asignar_medio';
$route['modificar-medio']                       = 'normal/nota/modificar_medio';

$route['temas']                                 = 'normal/tema/lista';
$route['guardar-tema']                          = 'normal/tema/registrar';
$route['search-tema']                           = 'normal/tema/search_temas';
$route['search-area']                           = 'normal/area/search_areas';
$route['search-dependecia']                     = 'normal/dependencia/search_dependencias';

$route['reporte-general']                       = 'normal/reporte/general';
$route['reporte-tematica']                      = 'normal/reporte/tematica';
$route['imprimir-reporte-tematica']             = 'normal/reporte/imprimir';
$route['imprimir-reporte-funcionario']          = 'normal/reporte/imprimir_fun';
$route['reporte-funcionario']                   = 'normal/reporte/funcionario';

/* DASHBOARD */
$route['ver-temas']                            = 'dashboard/dashboard/lista';
$route['obtener-notas']                        = 'dashboard/dashboard/obtain_notas';
$route['print-notas']                          = 'dashboard/dashboard/impresion';
$route['print-negas']                          = 'dashboard/dashboard/impresion_negas';
$route['print-posis']                          = 'dashboard/dashboard/impresion_posis';

$route['reporte-medio']                            = 'dashboard/reporte/lista';

/* AGENDA DE MEDIOS */
$route['agenda-medios']                         = 'agenda/agenda/lista';
$route['obtener-programas']                     = 'agenda/agenda/programas';
$route['guardar-programa']                      = 'agenda/agenda/registrar_programa';
$route['borrar-programa']                       = 'agenda/agenda/eliminar_programa';
$route['obtener-interlocutores']                = 'agenda/agenda/interlocutores';
$route['guardar-interlocutor']                  = 'agenda/agenda/registrar_interlocutor';
$route['borrar-interlocutor']                       = 'agenda/agenda/eliminar_interlocutor';
$route['guardar-espacio']                       = 'agenda/agenda/registrar_espacio';
$route['recuperar-espacio']                       = 'agenda/agenda/recuperar_espacio';
$route['guardar-agenda']                       = 'agenda/agenda/guardar_agenda';
$route['imprimir-agenda']                       = 'agenda/agenda/imprimir_espacio';
$route['obtener-espacios']                       = 'agenda/agenda/obtain_espacio';
$route['borrar-espacio']                       = 'agenda/agenda/eliminar_espacio';
$route['marcar-asistencia']                       = 'agenda/agenda/marcar_asistencia';

/* SERVICIOS */
$route['cambiar-estado']                        = 'utils/request/cambiar_estado';
$route['obtain-info']                           = 'utils/request/recuperar_info';


$route['torta']                                 = "normal/reporte/torta";
$route['ejemplo/(:any)']                        = "normal/pdf/ejemplo/$1";
$route['torta-fun/(:any)']                      = "normal/pdf/funcionario/$1";
$route['barras']                                = "normal/pdf/barras";


/* SERVICIOS  EJECUTIVO  */
$route['list-funcionarios']                   = "utils/request/lista_funcionarios";
$route['get-table']                           = "utils/request/vista_tabla";
$route['get-tabla-tendencia']                  = "utils/request/tabla_tendencias";
$route['get-barras-tendencia']                  = "utils/request/tendencias_barras";

$route['get-list-tendencia']                  = "utils/request/detalle_tendencias";
