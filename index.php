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
Routing::post('register','SecurityController');
Routing::get('workouts','DefaultController');
Routing::post('add','WorkoutController');
Routing::post('assign','WorkoutInfoController');
Routing::post('delete','WorkoutInfoController');
Routing::post('edit','WorkoutInfoController');
Routing::post('calorie','DefaultController');
Routing::post('onerepmax','DefaultController');
Routing::post('bmi','DefaultController');
Routing::post('logout','SecurityController');
Routing::post('addExercise','ExerciseController');
Routing::post('deleteExercise','ExerciseController');
Routing::post('settings','SecurityController');
Routing::post('changePassword','SecurityController');
Routing::post('deleteUser','SecurityController');

Routing::run($path);

?>
