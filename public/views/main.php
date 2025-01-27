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
    <div class="mainIconsContainer">
        <div id="welcomeText">  Welcome back! </div>

        <a class="mainiconContainer" href="/workouts">
            <i class="fa-solid fa-plus fa-3x mainicons"></i>
            <div class="mainIconText">Workouts</div>
        </a>
        <a class="mainiconContainer" href="/exercises">
            <i class="fa-solid fa-dumbbell fa-3x mainicons"></i>
            <div class="mainIconText">Exercises</div>
        </a>
        <div class="mainiconContainer">
            <i class="fa-solid fa-chart-simple fa-3x mainicons dropdown-toggle"></i>
            <button id="dropdownButton" onclick="showHide()">Tools</button>
        </div>

    </div>
    <div id="dropdown-menu">
        <a href="/calorie">Calorie calculator</a>
        <a href="/onerepmax">1RM calculator</a>
        <a href="/bmi">BMI calculator</a>
    </div>
</div>
<script>
    const div = document.getElementById('dropdown-menu');
    div.style.display = 'none'
    var display =1;
    function showHide() {
        if (display == 1) {
            div.style.display = 'flex'
            display = 0;
        }else {
            div.style.display = 'none'
            display = 1;
        }
    }
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