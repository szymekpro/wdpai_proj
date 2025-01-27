<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../images/image.png">
    <title> PeakFit </title>
    <link rel="stylesheet" href="../../styles/style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
</head>
<body>

<div id="main">
    <div id="logo">
        <img id="logoIMG" src="../../images/image.png"/>
        <div id="logoTitle">  PeakFit  </div>
    </div>

    <form class="register" action="/register" method="POST">

        <div class="loginMessage">
            <?php
            if (isset($messages)) {
                foreach ($messages as $message) {
                    echo  "<div class='message'>" . htmlspecialchars($message) . "</div>";;
                }
            }
            else {
                //echo "Message variable not set.";
            }
            ?>
        </div>

        <div id="loginBox">
            <div id="outerBox"></div>
            <div id="innerBox">
                <input class="loginInput" type="text" name="name" placeholder="name" />
            </div>
        </div>

        <div id="loginBox">
            <div id="outerBox"></div>
            <div id="innerBox">
                <input class="loginInput" type="text" name="surname" placeholder="surname" />
            </div>
        </div>

        <div id="loginBox">
            <div id="outerBox"></div>
            <div id="innerBox">
                <input class="loginInput" type="text" name="email" placeholder="email" />
            </div>
        </div>

        <div id="loginBox">
            <div id="outerBox"></div>
            <div id="innerBox">
                <input class="loginInput" type="text" name="password" placeholder="password" />
            </div>
        </div>

        <input id="registerButton" type="submit" value="Register" >


    </form>

</div>
<footer>
    <div id="line"> 2024-2024 PeakFit, Inc.  Privacy | Contact </div>
    <div id="footerBox">
        <a href="https://www.facebook.com/" target="_blank">
            <i class="fa-brands fa-facebook fa-3x"></i> </a>
        <a href="https://www.instagram.com/" target="_blank">
            <i class="fa-brands fa-instagram fa-3x"></i> </a>
        <a href="https://www.faceit.com/" target="_blank">
            <i class="fa-solid fa-info fa-3x"></i> </a>
    </div>
</footer>
</body>
</html>