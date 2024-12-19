<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/jpg" href="images/troll.jpg">
        <title> FACEIT </title>
        <link rel="stylesheet" href="main_style.css?v=<?= time(); ?>">
        <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header> 
            <div id="leftCornerLogo"> 
                <div id="logo">
                    <img id="logoIMG" src="images2/image.png"/>
                    <div id="logoTitle">  PeakFit  </div>
                </div>
            </div>
            <div id="headerOptions"> 
                <div class="iconContainer">
                <a href="main.php">
                    <i class="fa-solid fa-house fa-3x icons"></i></a> 
                        <div class="iconText">Home</div>
                </div>
                <div class="iconContainer">        
                    <!-- <i class="fa-solid fa-user fa-5x icons" class="icons"></i> -->
                    <img class="icons" src="images/faceit.jpg" id="kubica">
                    <div class="iconText">User</div>
                </div>
                <div class="iconContainer">
                    <i class="fa-solid fa-gear fa-3x icons" class="icons"></i>
                        <div class="iconText">Settings</div>
                </div>              
            </div>
        </header>

        <div id="main">
            <div class="mainIconsContainer">
                <div id="welcomeText">  Welcome back! </div>

                <a class="mainiconContainer" href="new_workout.php">
                    <i class="fa-solid fa-plus fa-3x mainicons"></i>
                        <div class="mainIconText">New workout</div>
                </a>
                <a class="mainiconContainer" href="main.php">
                    <i class="fa-solid fa-dumbbell fa-3x mainicons"></i>
                        <div class="mainIconText">Exercises</div>
                </a>
                <a class="mainiconContainer" href="main.php">
                    <i class="fa-solid fa-chart-simple fa-3x mainicons"></i>
                        <div class="mainIconText">History</div>
                </a>
            </div>
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