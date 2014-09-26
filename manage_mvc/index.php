<?php 
    session_start();
    define('APP_PATH', dirname(__FILE__));
    include APP_PATH . '/autoloader.php';
    // mlaphp_autoloader('models');

 //    function getURI(){
 //        if(!empty($_SERVER['REQUEST_URI'])) {
 //            return trim($_SERVER['REQUEST_URI'], '/');
 //        }
 
 //        if(!empty($_SERVER['PATH_INFO'])) {
 //            return trim($_SERVER['PATH_INFO'], '/');
 //        }
 
 //        if(!empty($_SERVER['QUERY_STRING'])) {
 //            return trim($_SERVER['QUERY_STRING'], '/');
 //        }
 //    }

 //    $uri = getURI();


	// $segments = explode('/', $uri);
	// array_shift($segments);
	// // Первый сегмент — контроллер.
	// $controller = ucfirst(array_shift($segments)).'Controller';
	// // Второй — действие.
	// $action = 'action'.ucfirst(array_shift($segments));
	// // Остальные сегменты — параметры.
	// $parameters = $segments;

	// // Подключаем файл контроллера, если он имеется
	// $controllerFile = APP_PATH . '/controllers/'.$controller.'.php';
	// // if(file_exists($controllerFile)){
	// //     include($controllerFile);
	// // }

	// // Если не загружен нужный класс контроллера или в нём нет
	// // нужного метода — 404 
	// // if(!is_callable(array($controller, $action))){
	// //     header("HTTP/1.0 404 Not Found");
	// //     return;
	// // }

	// // Вызываем действие контроллера с параметрами
	// call_user_func_array(array($controller, $action), $params);

	
	// $route = (!empty($_GET['route'])) ? explode('/', $_GET['route']) : array('controllers\IndexController', 'index');
	$route = (!empty($uri)) ? explode('/', $uri) : array('controllers\IndexController', 'index');
	$controller = new $route[1];
	$controller->{$route[2]}();