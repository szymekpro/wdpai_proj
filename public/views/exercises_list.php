<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../contents/images-spare/troll.jpg">
    <title> FACEIT </title>
    <link rel="stylesheet" href="../../styles/exercises_list_style.css?v=<?= time(); ?>">
    <script src="https://kit.fontawesome.com/acce5d3be5.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

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
            <a href="/main"">
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
    <form method="post">
        <div class="searchElements">
            <input type="text" id="searchInput" name="search" placeholder="search">
        </div>
    </form>
    <script>
        $(document).ready(function () {
            function fetchExercises(searchQuery = '') {
                $.ajax({
                    url: 'public/scripts/live_search.php',
                    method: 'POST',
                    data: { search: searchQuery },
                    success: function (response) {
                        $('#results').html(response);
                    }
                });
            }
            fetchExercises();
            $('#searchInput').on('keyup', function () {
                let searchQuery = $(this).val();
                fetchExercises(searchQuery); //
            });
        });
    </script>
    <div id="results"></div>
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