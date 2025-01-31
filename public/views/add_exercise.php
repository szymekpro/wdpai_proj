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

    <a class="goBackButtonContainer" href="/exercises">
        <div class="goBackButton">
            <i class="fa-solid fa-arrow-left icons"></i>
            <div class="goBackText"> Go back </div>
        </div>
    </a>

    <form class="addWorkoutBox" id="exerciseForm" method="POST">
        <div class="workoutNameBox">
            Exercise Creator
        </div>

        <div id="exerciseContainer">
            <div class="exerciseBox">
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="name" required placeholder="Name">
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="photo_path" required placeholder="/images/photo_name">
                </div>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="description" required placeholder="Description">
                </div>
                <select class="exerciseChoiceInput" name="category" required>
                    <?php
                    require_once __DIR__ . '/../../src/repository/ExerciseRepository.php';
                    $exerciseRepository = new ExerciseRepository();
                    $categories = $exerciseRepository->getAllCategories();

                    foreach ($categories as $category) {
                        echo '<option value="' . htmlspecialchars($category) . '">' . htmlspecialchars($category) . '</option>';
                    }
                    ?>
                </select>
                <div class="exerciseChoiceBox">
                    <input class="exerciseChoiceInput" type="text" name="difficulty" required placeholder="Difficulty">
                </div>
                <button type="button" class="saveExerciseButton" onclick="saveExercise()">Save Exercise</button>
            </div>
        </div>
    </form>

    <script>
        async function saveExercise() {
            const exerciseForm = document.getElementById('exerciseForm');
            const formData = new FormData(exerciseForm);

            try {
                const response = await fetch('/addExercise', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    alert('Exercise saved successfully!');
                    exerciseForm.reset();
                } else {
                    const error = await response.text();
                    alert('Error saving exercise: ' + error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An unexpected error occurred.');
            }
        }
    </script>
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
