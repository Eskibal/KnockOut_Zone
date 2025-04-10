<?php

session_start();

// connection to BBDD
$conn = new mysqli("localhost", "root", "", "knockoutzone");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// get user data
$sql = "SELECT * FROM users WHERE id = ?";
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
    <title>KnockoutZone - Profile</title>
</head>

<body>
    <header>
            <nav>
                <a href="userhome.html" id="logo">
                    <img id="logo" src="../images/logo.png" alt="Home">
                </a>
                <ul class="navul">
                    <li class="navli"><a href="#" class="nava">STORE</a></li>
                </ul>
                <ul class="navul">
                    <li class="navli"><a href="#" class="nava">FORUM</a></li>
                </ul>
                <ul class="navul">
                    <li class="navli"><a href="#" class="nava">RANKING</a></li>
                </ul>
                <ul class="navul">
                    <li class="navli"><a href="#" class="nava">FIGHTERS</a></li>
                </ul>
                <ul class="navul">
                    <li class="navli"><a href="knockoutevents.html" class="nava">EVENTS</a></li>
                </ul>
            </nav>
        </header>
    <div class="container">
        <h1>Bienvenido, <?php echo htmlspecialchars($user['user']); ?>!</h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <!--<p><strong>Rol:</strong> <?php //echo htmlspecialchars($user['role']); ?></p>-->

        <a href="../controller/logout.php" class="btn">Log out</a>
    </div>
</body>

</html>