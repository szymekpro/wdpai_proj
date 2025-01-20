<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/jpg" href="../../contents/images-spare/troll.jpg">
        <title> FACEIT </title>
        <link rel="stylesheet" href="../../styles/nw_style.css?v=<?= time(); ?>">
        <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
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
            <div class="workoutButtons">
                <a href="/add">
                    <button class="wButton"> New Workout </button>
                </a>
            </div>
            <div class="workoutText"> Your workouts:</div>
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

                echo '<div class="theWorkoutBox">
                <div class="workoutBoxHeader">
                    <div class="workoutBoxHeaderName">' . htmlspecialchars($workout->getName()) . '</div>
                    <div class="workoutBoxHeaderDate">' . htmlspecialchars($workout->getDate()) . '</div>
                    <div class="workoutActionButtons"><button class="workoutDeleteField" data-workout-id="' . htmlspecialchars($workoutId) . '"> delete </button>
                    <a href="/edit?id=' . $workoutId . '">
                    <button class="workoutEditField"  data-workout-id="' . htmlspecialchars($workoutId) . '"> edit </button>
                    </a></div>';
                $workoutRepository->setWorkoutExercises($workout);

                echo '</div><div class="workoutBoxMain">';

                foreach ($workout->getExercisesList() as $exercise) {
                    echo '<div class="workoutExercisesInfo">';
                    foreach ($workoutInfo as $workoutInf) {
                        if ($exercise->getId() == $workoutInf->getExerciseId()) {
                            echo '<div class="workoutExercisesInfoText">' . $exercise->getName() . '</div>
                          <div class="workoutExercisesInfoBox"> 
                              sets: <span class="spanStyle">' . $workoutInf->getSets() . '</span> 
                              reps: <span class="spanStyle">';

                            foreach ($workoutInf->getReps() as $rep) {
                                echo $rep . ', ';
                            }
                            echo '</span> weight: <span class="spanStyle">' . $workoutInf->getWeight() . ' kg</span>
                          </div>';
                        }
                    }
                    echo '</div>';
                }

                echo '</div></div><br>';
            }
            echo '</div>';
            ?>
        </div>
<!--        workoutDelete-->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const workoutDeleteFields = document.querySelectorAll('.workoutDeleteField');

                workoutDeleteFields.forEach(button => {
                    button.addEventListener('click', function () {
                        // Pobieramy ID treningu z atrybutu data-workout-id
                        const workoutId = button.getAttribute('data-workout-id');

                        if (workoutId) {
                            console.log('Workout ID:', workoutId);
                            const requestID = JSON.stringify({ workout_id: workoutId });
                            console.log('Request workout ID:', requestID);

                            // Tworzymy żądanie DELETE
                            const request = {
                                method: 'POST',
                                body: requestID,
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            };

                            fetch('/delete', request)
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        alert('Trening został pomyślnie usunięty!');
                                        location.reload();  // Odświeżenie strony po sukcesie
                                    } else {
                                        alert('Błąd: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Błąd podczas żądania:', error);
                                });
                        } else {
                            console.error('Brak ID treningu!');
                        }
                    });
                });
            });

        </script>
        <!--workoutEdit-->
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