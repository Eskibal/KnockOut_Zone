<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Recoger datos
    $name = $_POST['user'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 2. Validaciones simples
    if (empty($name) || empty($email) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // 3. Conexión PDO
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 4. Verificar si el email ya existe
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $_SESSION['error'] = "Este email ya está registrado.";
            header("Location: ../view/vregister.php");
            exit();
        }

        // 5. Hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 6. Insertar usuario
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        echo "¡Registro exitoso!";
        header("Location: ../view/vlogin.php");
        exit();
    } catch (PDOException $e) {
        echo "Error en el registro: " . $e->getMessage();
    }
}
