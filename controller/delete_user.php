<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../view/vlogin.php");
    exit();
}

$userId = $_SESSION['user_id'];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Borrar al usuario de la base de datos
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    // Cerrar sesión y redirigir al login
    session_unset();
    session_destroy();
    header("Location: ../view/vlogin.php");
    exit();

} catch (PDOException $e) {
    $_SESSION["error_update"] = "Error al eliminar la cuenta: " . $e->getMessage();
    header("Location: ../view/profile.php");
    exit();
}
?>
