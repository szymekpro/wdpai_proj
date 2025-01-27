<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';
require_once __DIR__ . '/../../src/repository/UserRepository.php';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $exerciseRepository = new ExerciseRepository();
    $userRepository = new UserRepository();

    $exercises = empty($search)
        ? $exerciseRepository->getAllExercises()
        : $exerciseRepository->getExercisesByName($search);

    if ($exercises) {
        foreach ($exercises as $exercise) {
            echo '<div class="exercise" data-id="' . htmlspecialchars($exercise->getID()) . '">';
            if ($exercise->getPhotoPath()) {
                echo '<img src="' . htmlspecialchars($exercise->getPhotoPath()) . '" alt="' . htmlspecialchars($exercise->getName()) . '" class="exercisePhoto">';
            }
            echo '<div class="exerciseTextBox">';
            echo '<div class="exerciseName">' . htmlspecialchars($exercise->getName()) . '</div>';
            echo '<div class="exerciseDescription">' . htmlspecialchars($exercise->getDescription()) . '</div>';
            if ($userRepository->isAdmin($_SESSION['user_id'])) {
                echo '<button class="deleteExerciseButton" onclick="window.deleteExercise('.$exercise->getID().')" >Usuń</button>';
            }
            echo '</div>';
            echo '</div>';
        }
    }
}
?>

