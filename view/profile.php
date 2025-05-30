<?php
session_start();
$conn = new mysqli("localhost", "root", "", "knockoutzone");
$user = $_SESSION["user_name"];

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
    <link rel="icon" href="../resources/images/logolightbig.png" sizes="256x256">
</head>

<body>
    <header>
        <nav>
            <a href="home.html" class="logo-container">
                <img src="../resources/images/logolight.png" alt="Knockout Zone Logo">
            </a>
            <ul class="nav-list">
                <li><a href="store.html">STORE</a></li>
                <li><a href="forum.html">FORUM</a></li>
                <li><a href="events.php">EVENTS</a></li>
                <li><a href="fighters.html">FIGHTERS</a></li>
            </ul>
            <a href="../controller/logout.php" class="btn">LOG OUT</a>
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

            <img src="https://i.redd.it/toouo8vhb1b81.png" alt="" class="banner">
            <?php if (!empty($row["path_pfp"])): ?>
                <img src="../resources/profiles/<?php echo htmlspecialchars($row["path_pfp"]); ?>" alt="Profile Picture">
            <?php else: ?>
                <p><img src="../resources/profiles/default-profile.png" alt="" class="default-profile"></p>
            <?php endif; ?>

            <h1>Welcome, <?php echo htmlspecialchars($row['name']); ?>!</h1>
            <?php echo htmlspecialchars($row['email']); ?>
            <hr>

            <h2>Update Your Information</h2>
            <form action="../controller/update_user.php" method="POST">
                <label for="name">New Username:</label>
                <input type="text" name="name" id="name" value="<?= htmlspecialchars($row['name']) ?>" required>

                <label for="email">New Email:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($row['email']) ?>" required>

                <input type="submit" value="Update Info">
            </form>

            <hr>
            <h2>Change Password</h2>
            <form action="../controller/update_password.php" method="POST">
                <label for="current_password">Current Password:</label>
                <input type="password" name="current_password" id="current_password" required>

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" id="new_password" required>

                <input type="submit" value="Change Password">
            </form>

            <hr>

            <?php if ($_SESSION["user_name"] === 'admin'): ?>
                <h2>Change Profile Picture</h2>
                <form action="../controller/subir_imagen.php" method="POST" enctype="multipart/form-data">
                    <input type="file" name="imagen" accept="image/*" required>
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>"><br>
                    <input type="submit" value="Upload Image">
                </form>
            <?php endif; ?>
            <hr>
            <h2>Delete Account</h2>
            <form action="../controller/delete_user.php" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.');">
                <input type="submit" value="Delete My Account" style="background-color: red; color: white;">
            </form>

        </div>
    </main>
</body>

</html>