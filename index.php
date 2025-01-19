<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);
//echo $path;

Routing::get('','DefaultController');
Routing::get('main','DefaultController');
Routing::get('exercises','DefaultController');
Routing::post('login','SecurityController');
Routing::get('new','DefaultController');
Routing::post('add','WorkoutController');
Routing::post('assign','WorkoutInfoController');
Routing::post('delete','WorkoutInfoController');
Routing::post('edit','WorkoutInfoController');
Routing::run($path);

?>
