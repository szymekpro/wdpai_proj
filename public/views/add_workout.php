<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../images/image.png">
    <title> PeakFit </title>
    <link rel="stylesheet" href="../../styles/edit_workout_style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header>
    <div id="leftCornerLogo">
        <div id="logo">
            <img id="logoIMG" src="../../images/image.png"/>
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

    <form class="addWorkoutBox" action="/assign" method="POST">

        <div class="workoutNameBox">
            <input type="text" id="workoutNameInput" name="name" required placeholder="workout name">
        </div>

        <div class="workoutDateBox">
            <input type="date" id="workoutDateInput" name="date" required placeholder="date">
        </div>

        <div id="exerciseContainer">
            <div class="exerciseBox">
                <div class="exerciseChoiceBox">
                    <select id="selectExerciseBox" name="exercises[exercise_id][]" required>
                    <?php
                    require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';
                    $exerciseRepository = new ExerciseRepository();
                    $exercises = $exerciseRepository->getAllExercises();

                    foreach ($exercises as $exercise) {
                        //echo $exercise->getName();
                        echo '<option value="' . $exercise->getId() . '">' . $exercise->getName() . '</option>';
                    }
                    ?>
                    </select>
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="number" name="exercises[sets][]" required placeholder="sets">
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="exercises[reps][]" required placeholder="reps">
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="number" step="0.1" name="exercises[weight][]" required placeholder="weight">
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="exercises[notes][]" required placeholder="notes">
                </div>
                <button type="button" class="removeExerciseButton">Remove</button>

            </div>
        </div>

        <div class="workoutActionButtons">
            <button type="button" id="addExerciseButton">Add Exercise</button>
        </div>
        <div class="workoutActionButtons">
        <button type="submit" id="workoutAddButton">Add Workout</button>
        </div>

    </form>

<!--    <script src="public/js/add_workout.js"></script>-->
    <script src="public/js/add_workout.js"></script>
</div>




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
