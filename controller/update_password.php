<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION["error"] = "Debes iniciar sesión.";
    header("Location: ../view/vlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $userId = $_SESSION['user_id'];

    if (empty($currentPassword) || empty($newPassword)) {
        $_SESSION["error"] = "Todos los campos son obligatorios.";
        header("Location: ../view/profile.php");
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1. Obtener contraseña actual
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. Verificar la contraseña actual
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            $_SESSION["error"] = "La contraseña actual no es correcta.";
            header("Location: ../view/profile.php");
            exit();
        }

        // 3. Encriptar nueva contraseña y actualizar
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashedPassword, $userId]);

        $_SESSION["success_password"] = "Contraseña actualizada correctamente.";
        header("Location: ../view/profile.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION["error_password"] = "Error al actualizar: " . $e->getMessage();
        header("Location: ../view/profile.php");
        exit();
    }
}
?>
