<?php
require_once 'src/repository/WorkoutRepository.php';
require_once 'src/repository/WorkoutInfoRepository.php';
require_once 'src/models/Exercise.php';

$workoutRepository = new WorkoutRepository();
$workoutInfoRepository = new WorkoutInfoRepository();
if (session_status() == PHP_SESSION_NONE) {
session_start();
}
$email = $_SESSION['user_email'];
$workouts = $workoutRepository->getAllWorkouts($email);
echo '<div class="workoutBox">';
    foreach ($workouts as $workout) {
    $workoutId = $workout->getId();

    $workoutInfo = $workoutInfoRepository->getWorkoutInfoByWorkout($workoutId);

    echo '<div class="theWorkoutBox"><div class="workoutBoxHeader"><div class="workoutBoxHeaderName">' . htmlspecialchars($workout->getName()) .'</div><div class="workoutBoxHeaderDate">' . htmlspecialchars($workout->getDate()) . '</div>';
            $workoutRepository->setWorkoutExercises($workout);
            echo '</div><div class="workoutBoxMain">';
            foreach ($workout->getExercisesList() as $exercise) {
            echo '<div class="workoutExercisesInfo">';

                foreach ($workoutInfo as $workoutInf) {
                if ($exercise->getId() == $workoutInf->getExerciseId()) {

                echo '<div class="workoutExercisesInfoText">' . $exercise->getName() . '</div>'. '<div class="workoutExercisesInfoBox">' . " sets: " . '<span class="spanStyle">' . $workoutInf->getSets().  '</span>'. " reps:" . '<span class="spanStyle">' . ' ';

                                foreach ($workoutInf->getReps() as $rep) {

                                    echo $rep . ', ';
                                }
                                echo '</span>'." weight: " . '<span class="spanStyle">'.$workoutInf->getWeight() . '</span>' . " kg" . '</div> ';
                }
                }
                echo '</div>';
            }
            echo '</div></div><br>';
    }
    echo '</div>';
    ?>