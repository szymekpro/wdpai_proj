<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $correctLogin = "admin";
    $correctPassword = "admin";

    if ($login == $correctLogin && $password == $correctPassword) {
        header("Location: main.php");
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}

?>