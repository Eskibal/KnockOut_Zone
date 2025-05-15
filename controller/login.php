<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Validaciones simples
    if (empty($email) || empty($password)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    try {
        // 2. Conexión PDO
        $pdo = new PDO("mysql:host=localhost;dbname=knockoutzone", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 3. Buscar el usuario por email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // 4. Login correcto: guardar datos en sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['path_pfp'] = $user['path_pfp'];

            // 5. Redirigir al perfil
            header("Location: ../view/profile.php");
            exit();
        } else {
            echo "Email o contraseña incorrectos.";
            exit();
        }

    } catch (PDOException $e) {
        echo "Error en el login: " . $e->getMessage();
    }
}
?>
