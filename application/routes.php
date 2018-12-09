<?php
/**
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register web routes for your application. This file is a parameter for
static method  load of the FrontController. The class name of FrontController is Routes.
|
 * @var \Acme\Core\Routes $router
*/
$router->get('/','PageController@index');
$router->get('/login','PageController@login');
$router->get('/register','PageController@register');
$router->get('/admin','PageController@admin');

$router->get('/notebook','NotebookController@index');
$router->get('/notebook/{notebook}','NotebookController@showNote');
$router->get('/notebook/{notebook}/price/{price}','NotebookController@price');

$router->get('/tablet','TabletController@index');
$router->get('/tablet/{tablet}','TabletController@showTablet');

$router->get('/desktop','DesktopPcController@index');
$router->get('/desktop/{desktop}','DesktopPcController@showPC');

$router->get('/mobile','MobileController@index');
$router->get('/mobile/{mobile}','MobileController@showMobile');

$router->get('/tv','TVController@index');
$router->get('/tv/{tv}','TVController@showTV');
