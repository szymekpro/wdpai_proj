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
        <h2>Kalkulator zapotrzebowania kalorycznego</h2>
        <form id="calorieCalculator">
            <div class="input-containers">
                <label class="input-labels" for="weight">Waga (kg)</label>
                <input type="number" id="weight" name="weight" required>
            </div>
            <div class="input-containers">
                <label class="input-labels" for="height">Wzrost (cm)</label>
                <input type="number" id="height" name="height" required>
            </div>
            <div class="input-containers">
                <label class="input-labels" for="age">Wiek (lat)</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="input-containers">
                <label class="input-labels" for="activity">Poziom aktywności fizycznej</label>
                <select id="activity" name="activity">
                    <option value="1.2">Brak aktywności</option>
                    <option value="1.375">Niska aktywność</option>
                    <option value="1.55">Średnia aktywność</option>
                    <option value="1.725">Wysoka aktywność</option>
                    <option value="1.9">Bardzo wysoka aktywność</option>
                </select>
                </div>
            <div class="input-containers">
            <div class="gender-options">
                <label class="gender-labels" for="male">Mężczyzna</label>
                <input type="radio" id="male" name="gender" value="male" checked>
                <label class="gender-labels" for="female">Kobieta</label>
                <input type="radio" id="female" name="gender" value="female">
            </div>
            </div>
            <div class="buttonField">
                <button type="submit">Oblicz</button>
            </div>
        </form>

        <div class="result" id="result"></div>
    </div>

</div>
<script>
    document.getElementById('calorieCalculator').addEventListener('submit', function(e) {
        e.preventDefault();

        const weight = parseFloat(document.getElementById('weight').value);
        const height = parseFloat(document.getElementById('height').value);
        const age = parseInt(document.getElementById('age').value);
        const activity = parseFloat(document.getElementById('activity').value);
        const gender = document.querySelector('input[name="gender"]:checked').value;

        if (!weight || !height || !age || !activity || !gender) {
            document.getElementById('result').innerText = "Proszę wprowadzić wszystkie dane.";
            return;
        }

        let BMR;
        if (gender === "male") {
            BMR = 10 * weight + 6.25 * height - 5 * age + 5;  // Mifflin-St Jeor
        } else if (gender === "female") {
            BMR = 10 * weight + 6.25 * height - 5 * age - 161;
        }

        const dailyCalories = BMR * activity;
        const caloriesMaintaining = Math.round(dailyCalories);
        const caloriesLosing = Math.round(dailyCalories - 500);
        const caloriesGaining = Math.round(dailyCalories + 500);
        document.getElementById('result').innerText = `
            Twoje dzienne zapotrzebowanie kaloryczne na utrzymanie wagi: ${caloriesMaintaining} kcal
            \nNa schudnięcie: ${caloriesLosing} kcal
            \nNa przytycie: ${caloriesGaining} kcal
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