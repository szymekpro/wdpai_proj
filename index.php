<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);
//echo $path;

Routing::get('','DefaultController');
Routing::get('main','DefaultController');
Routing::post('login','SecurityController');
Routing::run($path);

?>
