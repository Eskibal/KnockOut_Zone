<?php
include 'UserController.php';
$uc = new UserController();


    if (isset($_POST["login"])) {
        $uc->login();
    }
?>