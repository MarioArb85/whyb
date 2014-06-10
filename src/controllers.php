<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Arracamos sesion
session_start();

//Require configuracion mvc
require 'controladores/_listaControladores.php';
require 'vistas/_listaVistas.php';
require 'modelo/_listaModelos.php';

//firePHP
require_once '../vendor/FirePHPCore/FirePHP.class.php';
ob_start();
//instanciar un objeto de la clase FirePHP
$firephp = FirePHP::getInstance(true);

//Portada
$app->get('/', function () use ($app) {
    global $firephp;
    $titulo = "Where have you been";
    $header = header::construye((isset($_SESSION['user']))? $_SESSION['user'] : "");
    $body= inicio::construye();
    $footer = footer::construye();
    $paginaDetalle = new plantillaPagina($titulo, $header, $body, $footer);
    $pagina = $paginaDetalle->mostrar();
    //$firephp->log($paco, 'Mensaje');
    return $pagina;
})
->bind('homepage')
;

//Formulario
$app->get('/form/', function () use ($app) {
    return users_controller::form();
})
->bind('formulario')
;

//Resultado formulario
$app->post('/form/result/', function (Request $request) {
    return users_controller::alta_mod($request);
})
->bind('formulario_result')
;

//Registrarse
$app->get('/log/', function () use ($app) {
    return users_controller::iniciaSesion($problem);
})
->bind('log')
;

//Registrarse - resultado
$app->post('/log/result/', function (Request $request) {
    return users_controller::logResultado($request);
})
->bind('log_result')
;

//Map
$app->get('/map/', function () use ($app) {
    return maps_controller::draw();
})
->bind('map')
;

//Unesco
$app->get('/unesco/', function () use ($app) {
    return unesco_controller::draw();
})
->bind('unesco')
;

//Places
$app->get('/places/', function () use ($app) {
    return places_controller::draw();
})
->bind('places')
;

//Show my places
$app->get('/places/show/', function () use ($app) {
    return places_controller::myPlaces();
})
->bind('show_my_places')
;

//Menu usuario - datos usuario
$app->get('/menu/data/', function () use ($app) {
    return menu_controller::menu();
})
->bind('menu_data')
;

//Menu usuario - baja usuario
$app->get('/menu/delete/', function () use ($app) {
    return menu_controller::baja();
})
->bind('menu_delete')
;

//disconnect
$app->get('/disconnect/', function () use ($app) {
    return users_controller::disconnect();
})
->bind('disconnect')
;

//Administración página
$app->get('/admin/', function () use ($app) {
    return admin_controller::login();
})
->bind('admin')
;

//Logeo menu privado
$app->post('/admin/log/', function (Request $request) {
    return admin_controller::logAdmin($request);
})
->bind('admin_log')
;

//Administración página
$app->get('/admin/menu/', function () use ($app) {
    return admin_controller::menu();
})
->bind('admin_menu')
;

//Administración página
$app->get('/admin/menu/list/', function () use ($app) {
    return admin_controller::listado();
})
->bind('admin_menu_listado')
;

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html',
        'errors/'.substr($code, 0, 2).'x.html',
        'errors/'.substr($code, 0, 1).'xx.html',
        'errors/default.html',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});