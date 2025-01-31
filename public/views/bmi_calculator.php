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
            <img id="logoIMG" src="../../images/image.png""/>
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
        <h2>BMI calculator</h2>
        <form id="bmiCalculator">
            <div class="input-containers">
                <label for="weight">Weight (kg):</label>
                <input type="number" id="weight" name="weight" step="0.1" required>
            </div>

            <div class="input-containers">
                <label for="height">Height (cm):</label>
                <input type="number" id="height" name="height" step="0.1" required>
            </div>

            <button id="submit-button-v2" type="submit">Calculate BMI</button>
        </form>

        <div class="result" id="result"></div>
    </div>

</div>

<script src="public/js/tools.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        calculateBMI('bmiCalculator', 'result');
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