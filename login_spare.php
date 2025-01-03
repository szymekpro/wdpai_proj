<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" type="image/jpg" href="contents/images/troll.jpg">
        <title> FACEIT </title>
        <link rel="stylesheet" href="styles/style.css">
        <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    </head>
    <body>

        <div id="main">
        <div id="logo">
                <img id="logoIMG" src="contents/images2/image.png"/>
                <div id="logoTitle">  PeakFit  </div>
             </div>

            <form action="public/views/login.php" method="POST">

                <div id="loginBox">

                    <div id="outerBox"></div>
                        <div id="innerBox"> <input class="loginInput" type="text" name="login" placeholder="login" /></div>
                </div>

                <div id="loginBox">
                    <div id="outerBox"></div>
                        <div id="innerBox">  <input class="loginInput" type="text" name="password" placeholder="password" /></div>
                </div>

                <input id="loginButton" type="submit" value="Sign In">
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