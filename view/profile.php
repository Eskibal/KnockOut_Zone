<?php
session_start();
$conn = new mysqli("localhost", "root", "", "knockoutzone");
$user = $_SESSION["user"];

$query = $conn->prepare("SELECT * FROM users WHERE name = ?");
$query->bind_param("s", $user);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

// Mostrar errores o mensajes
if (isset($_SESSION["error"])) {
    echo "<p style='color:red'>" . $_SESSION["error"] . "</p>";
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    echo "<p style='color:green'>" . $_SESSION["success"] . "</p>";
    unset($_SESSION["success"]);
}

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
        <?php
        if (!empty($row["path_pfp"])) {
            echo "<img src='../images/profiles/" . $row["path_pfp"] . "' alt='Perfil' style='width:150px; border-radius:50%;'>";
        } else {
            echo "<p>No profile picture</p>";
        }

        // Formulario solo visible si eres admin
        if ($_SESSION["user"] === 'admin') {
            echo '
    <form action="../controller/subir_imagen.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="imagen" accept="image/*" required>
        <input type="hidden" name="name" value="' . $_SESSION['user'] . '">
        <input type="submit" value="Subir imagen">
    </form>';
        }
        ?>
        <h1>Welcome, <?php echo $row['name']; ?>!</h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>

        <a href="../controller/logout.php" class="btn">Log out</a>
    </div>
</body>

</html>