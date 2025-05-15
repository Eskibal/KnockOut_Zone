<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION["error"] = "Debes iniciar sesión.";
    header("Location: ../view/vlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $newName = $_POST['name'];
    $newEmail = $_POST['email'];
    $userId = $_SESSION['user_id'];

    if (empty($newName) || empty($newEmail)) {
        $_SESSION["error"] = "No puedes dejar los campos vacíos.";
        header("Location: ../view/profile.php");
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si el nuevo email ya está en uso por otro usuario
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$newEmail, $userId]);
        if ($stmt->fetch()) {
            $_SESSION["error_update"] = "Ese email ya está en uso.";
            header("Location: ../view/profile.php");
            exit();
        }

        // Actualizar datos
        $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        $stmt->execute([$newName, $newEmail, $userId]);

        // Actualizar también en la sesión
        $_SESSION['user_name'] = $newName;
        $_SESSION['user_email'] = $newEmail;

        $_SESSION["success_update"] = "Datos actualizados correctamente.";
        header("Location: ../view/profile.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION["error"] = "Error al actualizar: " . $e->getMessage();
        header("Location: ../view/profile.php");
        exit();
    }
}
