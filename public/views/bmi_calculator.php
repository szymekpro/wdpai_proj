<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="contents/images/troll.jpg">
    <title> FACEIT </title>
    <link rel="stylesheet" href="styles/main_style.css?v=<?= time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
</head>
<body>
<header>
    <div id="leftCornerLogo">
        <div id="logo">
            <img id="logoIMG" src="contents/images2/image.png"/>
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
            <img class="icons" src="contents/images/faceit.jpg" id="kubica">
            <div class="iconText"><?php
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                echo $_SESSION['user_email'];
                ?></div>
        </div>
        <div class="iconContainer">
            <i class="fa-solid fa-gear fa-3x icons" class="icons"></i>
            <div class="iconText">Settings</div>
        </div>
    </div>
</header>

<div id="main">
    <div class="calculatorContainer">
        <h2>Kalkulator BMI</h2>
        <form id="bmiCalculator">
            <label for="weight">Waga (kg):</label>
            <input type="number" id="weight" name="weight" step="0.1" required>

            <label for="height">Wzrost (cm):</label>
            <input type="number" id="height" name="height" step="0.1" required>

            <button type="submit">Oblicz BMI</button>
        </form>

        <div class="result" id="result"></div>
    </div>

</div>
<script>
    document.getElementById('bmiCalculator').addEventListener('submit', function(e) {
        e.preventDefault();

        const weight = parseFloat(document.getElementById('weight').value);
        const height = parseFloat(document.getElementById('height').value) / 100; // Zamiana cm na metry

        if (!weight || !height) {
            document.getElementById('result').innerText = "Proszę wprowadzić prawidłowe dane.";
            return;
        }

        const bmi = (weight / (height * height)).toFixed(2);

        let interpretation = '';
        if (bmi < 18.5) {
            interpretation = 'Niedowaga';
        } else if (bmi >= 18.5 && bmi <= 24.9) {
            interpretation = 'Waga prawidłowa';
        } else if (bmi >= 25 && bmi <= 29.9) {
            interpretation = 'Nadwaga';
        } else {
            interpretation = 'Otyłość';
        }

        document.getElementById('result').innerHTML = `
            Twoje BMI: <strong>${bmi}</strong> <br>
            Interpretacja: <strong>${interpretation}</strong>
        `;
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