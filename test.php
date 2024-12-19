<?php

use repository\ExerciseRepository;

require_once __DIR__ . '/repository/ExerciseRepository.php'; // Adjust path as needed
require_once __DIR__ . '/db/Database.php';
require_once __DIR__ . '/models/Exercise.php';

$exerciseRepository = new repository\ExerciseRepository();

$exercise =  $exerciseRepository->getExercise("Push-Up");

echo "Name: " . $exercise->getName() . "<br>";
echo "Description: " . $exercise->getDescription() . "<br>";
echo "Muscle Group: " . $exercise->getMuscleGroup() . "<br>";
echo "Difficulty: " . $exercise->getDifficulty() . "<br>";
echo "Photo Path: " . $exercise->getPhotoPath() . "<br>";

?>
