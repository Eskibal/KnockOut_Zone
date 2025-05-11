<?php
session_start();
$conn = new mysqli("localhost", "root", "", "knockoutzone");
$user = $_SESSION["user"];

$query = $conn->prepare("SELECT * FROM users WHERE name = ?");
$query->bind_param("s", $user);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

// Display errors or success messages
if (isset($_SESSION["error"])) {
    $error_message = $_SESSION["error"];
    unset($_SESSION["error"]);
}
if (isset($_SESSION["success"])) {
    $success_message = $_SESSION["success"];
    unset($_SESSION["success"]);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <title>KnockoutZone - Profile</title>
</head>

<body>
    <header>
        <nav>
            <a href="home.php" class="logo-container">
                <img src="../resources/images/logolight.png" alt="Knockout Zone Logo">
            </a>
            <ul class="nav-list">
                <li><a href="store.html">STORE</a></li>
                <li><a href="forum.html">FORUM</a></li>
                <li><a href="events.php">EVENTS</a></li>
                <li><a href="fighters.html">FIGHTERS</a></li>
                <li><a href="ranking.html">RANKING</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="container">
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if (isset($success_message)): ?>
                <p class="success-message"><?php echo htmlspecialchars($success_message); ?></p>
            <?php endif; ?>

            <?php if (!empty($row["path_pfp"])): ?>
                <img src="../resources/profiles/<?php echo htmlspecialchars($row["path_pfp"]); ?>" alt="Profile Picture">
            <?php else: ?>
                <p>No profile picture</p>
            <?php endif; ?>

            <?php if ($_SESSION["user"] === 'admin'): ?>
                <form action="../controller/subir_imagen.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="imagen" accept="image/*" required>
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($_SESSION['user']); ?>">
                    <input type="submit" value="Upload Image">
                </form>
            <?php endif; ?>

            <h1>Welcome, <?php echo htmlspecialchars($row['name']); ?>!</h1>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>

            <a href="../controller/logout.php" class="btn">Log out</a>
        </div>
    </main>
</body>

</html>