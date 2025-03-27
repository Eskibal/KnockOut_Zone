<?php
include 'UserController.php';
$uc = new UserController();

$uc->login();

if ($_SERVER('REQUESTED_METHOD') == 'POST') {
    if (isset($_POST["login"])) {
        header("Location:profile.php");
    }
}
?>