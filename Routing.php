<?php

require_once __DIR__ . '/src/controllers/DefaultController.php';
require_once __DIR__ . '/src/controllers/SecurityController.php';
require_once __DIR__ . '/src/controllers/WorkoutController.php';
require_once __DIR__ . '/src/controllers/WorkoutInfoController.php';
require_once __DIR__ . '/src/controllers/ExerciseController.php';


class Routing
{
    public static $routes;
    public static function get($url,$controller)
    {
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller) {
        self::$routes[$url] = $controller;
    }

    public static function run($url) {

        $extension = pathinfo($url, PATHINFO_EXTENSION);
        if (in_array($extension, ['js', 'css', 'jpg', 'png', 'gif', 'ico'])) {
            // Bezpośrednie serwowanie pliku
            $filePath = __DIR__ . '/' . $url;
            echo json_encode($filePath);
            if (file_exists($filePath)) {
                header("Content-Type: " . mime_content_type($filePath));
                readfile($filePath);
                exit;
            }
            die("Plik nie istnieje: $url");
        }

        $action = explode("/",$url)[0];
        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }


        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action();
    }
}

?>