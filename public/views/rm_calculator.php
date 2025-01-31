<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../images/image.png">
    <title> PeakFit </title>
    <link rel="stylesheet" href="styles/main_style.css?v=<?= time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
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
            <a href="/main"">
                <i class="fa-solid fa-house fa-3x icons"></i></a>
            <div class="iconText">Home</div>
        </div>
        <div class="iconContainer">
            <!-- <i class="fa-solid fa-user fa-5x icons" class="icons"></i> -->
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
    <div class="calculatorContainer">
        <h2>1RM Calculator</h2>
        <form id="oneRepMaxCalculator">

            <div class="input-containers">
                <label for="exercise">Select exercise:</label>
                <select id="exercise" name="exercise">
                    <option value="squat">Squat</option>
                    <option value="benchPress">Bench Press</option>
                    <option value="deadlift">Deadlift</option>
                    <option value="rows">Barbell row</option>
                </select>
            </div>

            <div class="input-containers">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" required>
            </div>

            <div class="input-containers">
                <label for="reps">Number of reps:</label>
                <input type="number" id="reps" name="reps" required>
            </div>

            <button id="submit-button-v2" type="submit">Calculate 1RM</button>
        </form>

        <div class="result" id="result"></div>
    </div>

</div>
<script src="public/js/tools.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        calculateOneRepMax('oneRepMaxCalculator', 'result');
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

</footer>
</body>
</html>