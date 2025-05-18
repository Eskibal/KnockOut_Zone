<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        $_SESSION["error"] = "Todos los campos son obligatorios.";
        header("Location: ../view/vadmin.php");
        exit();
    }

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verificar si ya existe el usuario
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION["error"] = "Este correo ya está registrado.";
            header("Location: ../view/vadmin.php");
            exit();
        }

        // Cifrar la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar el admin
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        $_SESSION["success"] = "Administrador registrado correctamente.";
        header("Location: ../view/vlogin.php");
        exit();

    } catch (PDOException $e) {
        $_SESSION["error"] = "Error: " . $e->getMessage();
        header("Location: ../view/vadmin.php");
        exit();
    }
}
?>
