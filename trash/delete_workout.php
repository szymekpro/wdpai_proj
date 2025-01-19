<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../contents/images/troll.jpg">
    <title> FACEIT </title>
    <link rel="stylesheet" href="../styles/nw_style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
<header>
    <div id="leftCornerLogo">
        <div id="logo">
            <img id="logoIMG" src="../contents/images2/image.png"/>
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
    <div class="workoutButtons">
        <a href="/add">
            <button class="wButton"> + new </button>
        </a>

        <a href="/delete">
            <button class="wButton"> - delete </button>
        </a>
    </div>

    <form id="deleteWorkoutForm" method="POST">
        <div class="workoutText"> Select workout to delete:</div>

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

        $workoutInfo = $workoutInfoRepository->getWorkoutInfoByWorkout($workout);
        $workoutName = $workout->getName();
        $workoutId = $workoutRepository->getWorkoutIdByName($workoutName);

        echo '<div class="theWorkoutDeleteBox" data-workout-id="' . htmlspecialchars($workoutId) .
            '"><div class="workoutBoxHeader"><div class="workoutBoxHeaderName">' . htmlspecialchars($workout->getName()) .
            '</div><div class="workoutBoxHeaderDate">' . htmlspecialchars($workout->getDate()) . '</div>';
        //echo htmlspecialchars($workoutId); ok
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

    echo '<input type="hidden" id="selectedWorkoutId" name="workout_id" value="">';

    ?>

        <button type="submit" id="deleteButton">Delete</button>
    </form>

</div>
<script>
    const deleteWorkoutForm = document.getElementById('deleteWorkoutForm');
    deleteWorkoutForm.addEventListener('submit', (event) => {
        event.preventDefault();
    })
    const deleteButton = document.getElementById('deleteButton');
    deleteButton.addEventListener('click', (event) => {
        event.preventDefault();
    })
    document.querySelectorAll('.theWorkoutDeleteBox').forEach(div => {
        div.addEventListener('click', function () {
            const previouslySelected = document.querySelector('.theWorkoutDeleteBox.selected');
            if (previouslySelected) {
                previouslySelected.classList.remove('selected');
            }
            this.classList.add('selected');

            const workoutId = this.getAttribute('data-workout-id');
            //console.log(workoutId);
            document.getElementById('selectedWorkoutId').value = workoutId;
        });
    });

</script>
<script>
    document.getElementById('deleteWorkoutForm').addEventListener('submit', function (event) {
        event.preventDefault();  // Zapobiega domyślnemu zachowaniu formularza

        const workoutId = document.getElementById('selectedWorkoutId').value;
        const request = JSON.stringify({ workout_id: workoutId })

        console.log(workoutId);

        fetch('delete', {
            method: 'POST',
            body: request,
            headers: {
                'Content-Type': 'application/json'
            }
        })
            .then(function (response) {
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Trening został pomyślnie usunięty!');
                    location.reload();  // Odświeżenie strony po sukcesie
                } else {
                    alert('Błąd: ' + data.message);
                }
            })
            .catch(error => console.error('Błąd podczas żądania:', error));
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