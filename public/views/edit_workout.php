<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../images/image.png">
    <title> PeakFit </title>
    <link rel="stylesheet" href="../../styles/add_workout_style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div id="leftCornerLogo">
        <div id="logo">
            <img id="logoIMG" src="../../images/image.png""/>
            <div id="logoTitle">  PeakFit  </div>
        </div>
    </div>


    <div id="headerOptions">
        <div class="iconContainer">
            <a href="/main">
                <i class="fa-solid fa-house fa-3x icons"></i></a>
            <div class="iconText">Home</div>
        </div>

        <div class="iconContainer">
            <i class="fa-solid fa-user fa-5x icons" class="icons"></i>
            <div class="iconText"><?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                echo $_SESSION['user_email'];
                ?></div>
        </div>
        <div class="iconContainer">
            <a href="/settings">
                <i class="fa-solid fa-gear fa-3x icons" class="icons"></i>
            </a>
            <div class="iconText">Settings</div>
        </div>
    </div>
    <a href="/logout">
        <div class="logoutContainer"> logout </div>
    </a>
</header>

<div id="main">

    <a class="goBackButtonContainer" href="/workouts">
        <div class="goBackButton">
            <i class="fa-solid fa-arrow-left icons"></i>
            <div class="goBackText"> Go back </div>
        </div>
    </a>

    <form id="editWorkoutForm" action="/edit?id=<?php echo $workoutId; ?>" method="POST">

        <div id="exerciseContainer">

            <?php
            require_once 'src/repository/WorkoutRepository.php';
            require_once 'src/repository/WorkoutInfoRepository.php';
            require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';
            require_once 'src/models/Exercise.php';

            $workoutRepository = new WorkoutRepository();
            $workoutInfoRepository = new WorkoutInfoRepository();
            $exerciseRepository = new ExerciseRepository();

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $email = $_SESSION['user_email'];
            $workout = $workoutRepository->getWorkout($email,$workoutId);

            echo '<div class="workoutNameBox"><input type="text" id="workoutNameInput" name="name" required value="' . htmlspecialchars($workout->getName()) . '"></div>
                <div class="workoutDateBox"><input type="date" id="workoutDateInput" name="date" required value="' . htmlspecialchars($workout->getDate()) . '"></div>';

            $workoutInfo = $workoutInfoRepository->getWorkoutInfoByWorkout($workout);
            $workoutRepository->setWorkoutExercises($workout);

            //echo '<div class="exerciseBox">';


            echo '<div class="exerciseBox">';
            foreach ($workoutInfo as $workoutInf) {

                $workoutInfoExercise = $workoutInfoRepository->getExerciseByWorkoutInfo($workoutInf->getExerciseId());

                $dynamicOptions = '';
                $exercises = $exerciseRepository->getAllExercises();
                $defaultValue = $workoutInf->getExerciseId();

                foreach ($exercises as $baseExercise) {
                    $isSelected = $baseExercise->getId() == $defaultValue ? 'selected' : '';
                    $dynamicOptions .= '<option value="' . $baseExercise->getId() . '" ' . $isSelected . '>' . $baseExercise->getName() . '</option>';
                }

                echo '<div class="particularExerciseBox">';
                echo '<select id="selectExerciseBox" name="exercises[exercise_id][]" required>' . $dynamicOptions . '</select>
                      <div class="exerciseChoiceBox"><input class="exerciseChoiceInput" type="number" name="exercises[sets][]" required value="'. htmlspecialchars($workoutInf->getSets()) .'"></div>                         
                      <div class="exerciseChoiceBox">
                      <input class="exerciseChoiceInput" type="text" name="exercises[reps][]" required value="' . htmlspecialchars($workoutInf->repsToString()) . '"></div>
                      <div class="exerciseChoiceBox">
                      <input class="exerciseChoiceInput" type="number" step="0.1" name="exercises[weight][]" required value="'. htmlspecialchars($workoutInf->getWeight()) .'"></div>
                      <div class="exerciseChoiceBox"><input class="exerciseChoiceInput" type="text" name="exercises[notes][]" required value="' .htmlspecialchars($workoutInf->getNotes()) . '"></div>
                      <input type="hidden" name="existing_exercises[]" value="' . htmlspecialchars($workoutInf->getExerciseId()) . '">
                      <button type="button" class="removeExerciseButton">Remove</button>
                      ';
                echo '</div>';

            }
            echo '</div>';
            ?>
        </div>

        <div id="removedExercisesContainer"></div>

        <div class="workoutActionButtons">
            <button type="button" id="addExerciseButton">Add Exercise</button>
        </div>

        <div class="workoutActionButtons">
            <button type="submit" id="workoutAddButton">Submit edit</button>
        </div>


    </form>
</div>
<script src="public/js/edit_workout.js"></script>

<footer>
    <div id="line"> 2024-2024 PeakFit, Inc.  Privacy | Contact </div>
    <div id="footerBox">
        <a href="https://www.facebook.com/" target="_blank">
            <i class="fa-brands fa-facebook fa-3x icons"></i> </a>
        <a href="https://www.instagram.com/" target="_blank">
            <i class="fa-brands fa-instagram fa-3x icons"></i> </a>
        <a href="https://www.faceit.com/" target="_blank">
            <i class="fa-solid fa-info fa-3x icons"></i> </a>
    </div>
</footer>
</body>
</html>
