<?php

	// configure your app for the production environment

	$app['twig.path'] = array(__DIR__.'/../templates');
	$app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');

	$aux1 = $_SERVER['DOCUMENT_ROOT'];
	$aux2 = dirname(__DIR__);

	//carpeta padre
	//define("DIR_RAIZ_APP", dirname(__DIR__));

	//Variables mias
	define("DIR_RAIZ_APP", '/whyb/');

	//RUTAS CARPETAS
	//Carpeta librerias -> vendor
	define("DIR_LIBS", DIR_RAIZ_APP."vendor");

	//Ruta controladores
	define("DIR_CONTROLADORES", DIR_RAIZ_APP."src/controladores/");
	//define("DIR_CONTROLADORES", "/whyb/src/controladores/");

	//Ruta modelo
	define("DIR_MODELO", DIR_RAIZ_APP."src/modelo/");

	//Ruta vistas
	define("DIR_VISTAS", DIR_RAIZ_APP."src/vistas/");

	//Ruta css
	define("DIR_CSS", DIR_RAIZ_APP."web/css/");

	//Ruta js
	define("DIR_JS", DIR_RAIZ_APP."web/js/");

	//Ruta img
	define("DIR_IMG", DIR_RAIZ_APP."web/img/");

	//RUTAS PAGINAS
	//Ruta font
	define("DIR_FONT", DIR_RAIZ_APP."web/font/");

	//Pagina inicio
	define("DIR_INICIO", DIR_RAIZ_APP."web/");

	//Pagina form
	define("DIR_FORM", DIR_RAIZ_APP."web/form/");

	//Pagina unesco
	define("DIR_UNESCO", DIR_RAIZ_APP."web/unesco/");

	//Pagina maps
	define("DIR_MAP", DIR_RAIZ_APP."web/map/");

	//Pagina places
	define("DIR_PLACES", DIR_RAIZ_APP."web/places/");

	//Pagina places
	define("DIR_SHOW_PLACES", DIR_RAIZ_APP."web/places/show/");