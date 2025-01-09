<?php
/*
require_once __DIR__ . '/src/repository/ExerciseRepository.php';
require_once __DIR__ . '/db/Database.php';
require_once __DIR__ . '/src/models/Exercise.php';

if (isset($_POST["sumbit"])) {
    $search = $_POST["search"];
    $exerciseRepository = new ExerciseRepository();
    $exercise = $exerciseRepository->getExercise($search);
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
else
{
    include "exercises_list_script.php";
}
*/


require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';

if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $exerciseRepository = new ExerciseRepository();
    $exercises = $exerciseRepository->getExercisesByName($search);

    if (empty($search)) {
        $exercises = $exerciseRepository->getAllExercises();
    } else {
        $exercises = $exerciseRepository->getExercisesByName($search);
    }

    if ($exercises) {
        foreach ($exercises as $exercise) {
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
    } else {
        echo '<p>No exercises found.</p>';
    }
}


?>
