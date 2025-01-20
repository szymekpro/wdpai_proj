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
        <h2>Kalkulator 1RM</h2>
        <form id="oneRepMaxCalculator">
            <label for="exercise">Wybierz ćwiczenie:</label>
            <select id="exercise" name="exercise">
                <option value="squat">Przysiad</option>
                <option value="benchPress">Wyciskanie na ławce</option>
                <option value="deadlift">Martwy ciąg</option>
                <option value="rows">Wiosłowanie</option>
            </select>

            <label for="weight">Waga (kg):</label>
            <input type="number" id="weight" name="weight" required>

            <label for="reps">Liczba powtórzeń:</label>
            <input type="number" id="reps" name="reps" required>

            <button type="submit">Oblicz 1RM</button>
        </form>

        <div class="result" id="result"></div>
    </div>

</div>
<script>
    document.getElementById('oneRepMaxCalculator').addEventListener('submit', function(e) {
        e.preventDefault();

        const weight = parseFloat(document.getElementById('weight').value);
        const reps = parseInt(document.getElementById('reps').value);
        const exercise = document.getElementById('exercise').value;

        if (!weight || !reps || !exercise) {
            document.getElementById('result').innerText = "Proszę wprowadzić wszystkie dane.";
            return;
        }

        let oneRepMax = 0;
        if (exercise === "squat") {
            oneRepMax = weight * (1 + 0.0333 * reps);
        } else if (exercise === "benchPress") {
            oneRepMax = weight * (1 + 0.025 * reps);
        } else if (exercise === "deadlift") {
            oneRepMax = weight * (1 + 0.0277 * reps);
        } else if (exercise === "rows") {
            oneRepMax = weight * (1 + 0.0333 * reps);
        }

        oneRepMax = oneRepMax.toFixed(2);

        document.getElementById('result').innerText = `Twoje 1RM dla tego ćwiczenia to: ${oneRepMax} kg`;
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