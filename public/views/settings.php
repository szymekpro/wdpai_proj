<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/jpg" href="../../images/image.png">
    <title> PeakFit </title>
    <link rel="stylesheet" href="../../styles/add_workout_style.css?v=<?= time(); ?>">
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
            <a href="/main">
                <i class="fa-solid fa-house fa-3x icons"></i></a>
            <div class="iconText">Home</div>
        </div>
        <div class="iconContainer">
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

    <?php
    require_once "src/repository/UserRepository.php";

    $userRepository = new UserRepository();
    $user = $userRepository->getUserByID($_SESSION['user_id']);
    ?>

    <div class="user-data-box">
        <div class="single-user-data-box">
            <div class="user-data-label">Name:</div>
            <div class="user-data-info"><?php echo $user->getName(); ?></div>
        </div>

        <div class="single-user-data-box">
            <div class="user-data-label">Surname:</div>
            <div class="user-data-info"><?php echo $user->getSurname(); ?></div>
        </div>

        <div class="single-user-data-box">
            <div class="user-data-label">Email:</div>
            <div class="user-data-info"><?php echo $user->getEmail(); ?></div>
        </div>

        <div class="single-user-data-box">
            <button class="user-data-change-password" onclick="showHide()">Change password</button>
        </div>

        <form id="change-password-form" method="post">
            <input class="change-password-form-input" type="text" name="old_password" required placeholder="Old password">
            <input class="change-password-form-input" type="text" name="new_password" required placeholder="New password">
            <button class="change-password-submit-button" type="submit">Submit</button>
        </form>

        <div class="single-user-data-box">
            <button class="user-data-delete-account">Delete account</button>
        </div>

        <div id="messages-container">
        <?php
        if (isset($messages)) {
            foreach ($messages as $message) {
                echo  "<div class='message'>" . htmlspecialchars($message) . "</div>";;
            }
        }
        ?></div>

    </div>

</div>

<script>
    const div = document.getElementById('change-password-form');
    div.style.display = 'none'
    var display = 1;

    function showHide() {
        if (display == 1) {
            div.style.display = 'flex'
            display = 0;
        }else {
            div.style.display = 'none'
            display = 1;
        }
    }

    function deleteSelfUser() {

    }

    document.getElementById('change-password-form').addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(event.target);
        const data = {
            old_password: formData.get('old_password'),
            new_password: formData.get('new_password'),
        };

        try {
            const response = await fetch('/changePassword', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const messagesContainer = document.getElementById('messages-container');
            messagesContainer.innerHTML = '';

            if (response.ok) {
                const result = await response.json();

                if (result.messages) {
                    result.messages.forEach((message) => {
                        messagesContainer.innerHTML += `<div class="message">${message}</div>`;
                    });
                } else if (result.message === 'success') {
                    messagesContainer.innerHTML = '<div class="message">Password changed successfully!</div>';
                }
            } else {
                messagesContainer.innerHTML = '<div class="message">An error occurred during the password change. Please try again.</div>';
            }
        } catch (error) {
            document.getElementById('messages-container').innerHTML = '<div class="message">A network error occurred.</div>';
            console.error('Network error:', error);
        }
    });

    document.querySelector('.user-data-delete-account').addEventListener('click', async () => {

        const confirmation = confirm('Are you sure you want to delete your account?.');

        if (!confirmation)
            return;

        try {

            const response = await fetch('/deleteUser', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (response.ok) {
                const result = await response.json();

                if (result.message === 'success') {
                    alert('Your account has been deleted successfully.');
                    window.location.href = '/login';
                } else {
                    alert('There was an issue deleting your account. Please try again later.');
                }
            } else {
                alert('An error occurred while trying to delete your account.');
            }
        } catch (error) {
            console.error('Network error:', error);
            alert('A network error occurred. Please try again later.');
        }
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