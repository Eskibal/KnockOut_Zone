<?php
session_start();
include 'UserController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uc = new UserController();
    $uc->registerAdmin();
} else {
    header("Location: ../view/vadmin.php");
    exit();
}
