<?php

    session_start();

    $passwordErr = $userErr = "";
    $password = $user = "";

    if ($_SERVER("REQUEST_METHOD") == "POST") {
        if (empty($_POST['user'])) {
            $userErr = "Por favor introduzca un usuario válido";
        } elseif (empty($_POST['password'])) {
            $passwordErr = "Por favor introduzca una contraseña válida";
        } else {
            $user = $_POST['user'];
            $password = $_POST['password'];
        }

        if(isset($_POST['submit'])) {
            $uc->login();
        }
    }
?>