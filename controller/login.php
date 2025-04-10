<?php
session_start();
include 'UserController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uc = new UserController();
    $uc->login();
} else {
    header("Location: ../view/knockoutlogin.php");
    exit();
}
