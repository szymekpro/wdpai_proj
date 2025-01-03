<?php

require_once __DIR__ . '/src/repository/ExerciseRepository.php'; // Adjust path as needed
require_once __DIR__ . '/db/Database.php';
require_once __DIR__ . '/src/models/Exercise.php';

$exerciseRepository = new \src\repository\ExerciseRepository();
$exerciseList = $exerciseRepository->getAllExercises();

if (!empty($exerciseList)) {
    echo '<div class="exercisesContainer">';
    foreach ($exerciseList as $exercise) {
        echo '<div class="exercise">';
        if ($exercise->getPhotoPath()) {
            echo '<img src="' . htmlspecialchars($exercise->getPhotoPath()) . '" alt="' . htmlspecialchars($exercise->getName()) . '" class="exercisePhoto">';
        }
        echo '<div class="exerciseTextBox">';
        echo '<div class="exerciseName">' . htmlspecialchars($exercise->getName()) . '</div>';
        echo '<div class="exerciseDescription">' . htmlspecialchars($exercise->getDescription()) . '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
} else {
    echo '<p>No exercises found.</p>';
}

?>
