<?php
session_start();
$conn = new mysqli("localhost", "root", "", "knockoutzone");
$user = $_SESSION["user"];

$query = $conn->prepare("SELECT path_pfp FROM users WHERE name = ?");
$query->bind_param("s", $user);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if (!empty($row["path_pfp"])) {
    echo "<img src='../images/profiles/" . $row["path_pfp"] . "' alt='Perfil' style='width:150px; border-radius:50%;'>";
} else {
    echo "<p>No profile picture</p>";
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
        <h1>Bienvenido, <?php echo htmlspecialchars($user['name']); ?>!</h1>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <!--<p><strong>Rol:</strong> <?php //echo htmlspecialchars($user['role']); ?></p>-->

        <a href="../controller/logout.php" class="btn">Log out</a>
    </div>
</body>

</html>
