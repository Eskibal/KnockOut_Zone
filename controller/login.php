<?php
    session_start();

    $user = $_POST["user"];
    $password = $_POST["password"];


    if ($_SERVER("REQUEST_METHOD") == "POST") {
        if (empty($_POST['user'])) {
            header("Location:knockoutlogin.html");
        } elseif (empty($_POST['password'])) {
            header("Location:knockoutlogin.html");
        } else {
            $_SESSION["user"] = $user;
            $_SESSION["password"] = $password;
            header("Location:profile.php");
        }
    }
?>