
<?php
    require 'Routing.php';

    $path = trim($_SERVER['REQUEST_URI'], '/');
    $path = parse_url($path, PHP_URL_PATH);
    //echo $path;

    Routing::get('index','DefaultController');
    Routing::get('projects','DefaultController');
    Routing::run($path);


    ?>
