<?php
session_start();
include 'UserController.php';

$uc = new UserController();
$uc->subirImagenPerfil();
