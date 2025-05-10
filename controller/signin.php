<?php
session_start();
include 'UserController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $uc = new UserController();
    $uc->register();
} else {
    header("Location: ../view/vregister.php");
    exit();
}
