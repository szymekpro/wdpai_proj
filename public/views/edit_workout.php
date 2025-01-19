<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../contents/images/troll.jpg">
    <title> FACEIT </title>
    <link rel="stylesheet" href="../../styles/add_workout_style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div id="leftCornerLogo">
        <div id="logo">
            <img id="logoIMG" src="../../contents/images2/image.png"/>
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
            <div class="iconText">User</div>
        </div>
        <div class="iconContainer">
            <i class="fa-solid fa-gear fa-3x icons" class="icons"></i>
            <div class="iconText">Settings</div>
        </div>
    </div>
</header>

<div id="main">

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

            foreach ($workout->getExercisesList() as $exercise) {
                echo '<div class="exerciseBox">';
                foreach ($workoutInfo as $workoutInf) {

                    if ($exercise->getId() == $workoutInf->getExerciseId()) {

                        $dynamicOptions = '';
                        $exercises = $exerciseRepository->getAllExercises();
                        $defaultValue = $workoutInf->getExerciseId();

                        foreach ($exercises as $baseExercise) {
                            $isSelected = $baseExercise->getId() == $defaultValue ? 'selected' : '';
                            $dynamicOptions .= '<option value="' . $baseExercise->getId() . '" ' . $isSelected . '>' . $baseExercise->getName() . '</option>';
                        }


                        echo '<select name="exercises[exercise_id][]" required>' . $dynamicOptions . '</select>
                              <div class="exerciseChoiceBox"><input class="exerciseChoiceInput" type="number" name="exercises[sets][]" required value="'. htmlspecialchars($workoutInf->getSets()) .'"></div>                         
                              <div class="exerciseChoiceBox">
                              <input class="exerciseChoiceInput" type="text" name="exercises[reps][]" required value="' . htmlspecialchars($workoutInf->repsToString()) . '"></div>
                            <div class="exerciseChoiceBox">
                            <input class="exerciseChoiceInput" type="number" step="0.1" name="exercises[weight][]" required value="'. htmlspecialchars($workoutInf->getWeight()) .'"></div>
                            <div class="exerciseChoiceBox"><input class="exerciseChoiceInput" type="text" name="exercises[notes][]" required value="' .htmlspecialchars($workoutInf->getNotes()) . '"></div>
                          <button type="button" class="removeExerciseButton">Usuń</button>
                          ';
                    }

                }
                echo '</div>';
            }
            ?>
            </div>
        <button type="button" id="addExerciseButton">Dodaj Ćwiczenie</button>
        <button type="submit" id="workoutEditButton">Sumbit edit</button>
        </div>
    </form>


<!--    <?php
//    require_once 'src/repository/WorkoutRepository.php';
//    require_once 'src/repository/WorkoutInfoRepository.php';
//    require_once 'src/models/Exercise.php';
//
//    $workoutRepository = new WorkoutRepository();
//    $workoutInfoRepository = new WorkoutInfoRepository();
//
//    if (session_status() == PHP_SESSION_NONE) {
//        session_start();
//    }
//    $email = $_SESSION['user_email'];
//    $workout = $workoutRepository->getWorkout($email,$workoutId);
//
//    echo '<div class="workoutBox">';
//
//        $workoutInfo = $workoutInfoRepository->getWorkoutInfoByWorkout($workout);
//        $workoutName = $workout->getName();
//        $workoutId = $workoutRepository->getWorkoutIdByName($workoutName);
//
//        echo '<div class="theWorkoutBox">
//                <div class="workoutBoxHeader">
//                    <div class="workoutBoxHeaderName">' . htmlspecialchars($workout->getName()) . '</div>
//                    <div class="workoutBoxHeaderDate">' . htmlspecialchars($workout->getDate()) . '</div>
//                    <button class="workoutDeleteField" data-workout-id="' . htmlspecialchars($workoutId) . '"> delete </button>
//                    <a href="/edit?id=' . $workoutId . '">
//                    <button class="workoutEditField"  data-workout-id="' . htmlspecialchars($workoutId) . '"> edit </button>
//                    </a>';
//        $workoutRepository->setWorkoutExercises($workout);
//
//        echo '</div><div class="workoutBoxMain">';
//
//        foreach ($workout->getExercisesList() as $exercise) {
//            echo '<div class="workoutExercisesInfo">';
//            foreach ($workoutInfo as $workoutInf) {
//                if ($exercise->getId() == $workoutInf->getExerciseId()) {
//                    echo '<div class="workoutExercisesInfoText">' . $exercise->getName() . '</div>
//                          <div class="workoutExercisesInfoBox">
//                              sets: <span class="spanStyle">' . $workoutInf->getSets() . '</span>
//                              reps: <span class="spanStyle">';
//
//                    foreach ($workoutInf->getReps() as $rep) {
//                        echo $rep . ', ';
//                    }
//                    echo '</span> weight: <span class="spanStyle">' . $workoutInf->getWeight() . ' kg</span>
//                          </div>';
//                }
//            }
//            echo '</div>';
//        }
//
//        echo '</div></div><br>';
//    echo '</div>';
//    ?> -->

</div>
<script>
    const addExerciseButton = document.getElementById('addExerciseButton');
    const exerciseContainer = document.getElementById('exerciseContainer');

    addExerciseButton.addEventListener('click', () => {
        const exerciseDiv = document.querySelector('.exerciseBox').cloneNode(true);

        const exerciseInput = exerciseDiv.querySelector('select[name="exercises[exercise_id][]"]');
        if (exerciseInput) {
            exerciseInput.value = '';
        }

        const setsInput = exerciseDiv.querySelector('input[name="exercises[sets][]"]');
        if (setsInput) {
            setsInput.value = '';
            setsInput.placeholder = 'sets';
        }

        const repsInput = exerciseDiv.querySelector('input[name="exercises[reps][]"]');
        if (repsInput) {
            repsInput.value = '';
            repsInput.placeholder = 'reps';
        }

        const weightInput = exerciseDiv.querySelector('input[name="exercises[weight][]"]');
        if (weightInput) {
            weightInput.value = ''; // Wyczyść wartość
            weightInput.placeholder = 'weight (kg)'; // Dodaj placeholder
        }

        const notesInput = exerciseDiv.querySelector('input[name="exercises[notes][]"]');
        if (notesInput) {
            notesInput.value = '';
            notesInput.placeholder = 'notes';
        }

        exerciseContainer.appendChild(exerciseDiv);

        const removeButton = exerciseDiv.querySelector('.removeExerciseButton');
        removeButton.addEventListener('click', () => {
            exerciseDiv.remove();
        });
    });
</script>
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
    </div>
</footer>
</body>
</html>
