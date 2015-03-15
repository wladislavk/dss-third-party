<?php namespace Ds3\Legacy; ?><?php 
    session_start();
    define('APP_PATH', dirname(__FILE__));
    define('ROOT_URI', '/manage_mvc/');
    
    include APP_PATH . '/autoloader.php';

	$routes = explode('/', $_SERVER['REQUEST_URI']);

	if (empty($routes[2])) {
		$routes[2] = 'index';
	}
	if (empty($routes[3])) {
		$routes[3] = 'index';
	}

	$routes[2] = 'controllers\\' . $routes[2] . 'Controller';
	$controller = new $routes[2];
	$controller->{$routes[3]}();
