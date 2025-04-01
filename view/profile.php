<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location:login.php");
    exit();
}

// connection to BBDD
$conn = new mysqli("localhost", "root", "", "knockoutzone");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// get user data
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, password FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// log out connection
$stmt->close();
$conn->close();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="viewcss/profile.css">
    <title>Profile</title>
</head>

<body>

    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($user['user']); ?>!</h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <!--<p><strong>Rol:</strong> <?php //echo htmlspecialchars($user['role']); ?></p>-->

        <a href="logout.php" class="btn">Log out</a>

</body>

</html>