<?php
session_start();
$error = $_SESSION["error"] ?? null;
unset($_SESSION["error"]);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Knockout Zone</title>
    <link rel="stylesheet" href="css/register.css">
    <link rel="icon" href="../resources/images/logolightbig.png" sizes="256x256">
</head>

<body>
    <div class="form-container">
        <h1>USER REGISTER</h1>
        <?php if ($error): ?>
            <p style="color: red; text-align: center; font-weight: bold;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form action="../controller/signin.php" method="POST" enctype="multipart/form-data">
            <hr>
            <input type="hidden" name="register" value="1">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" placeholder="user@email.com" required>
            <div class="label-group">
                <label for="user">Username *</label>
                <label for="password">Password *</label>
            </div>
            <div class="form-group">
                <input type="text" name="user" id="user" placeholder="knockout_user" required>&nbsp;
                <input type="password" name="password" id="password" placeholder="123ABC.." required>
            </div>
            <input type="submit" value="Register">
            <hr>
            <div class="form-options">
                Got an account? <a href="vlogin.php"> Log in!</a>
                <br>Become a <a href="vadmin.php">Knockout Admin!</a></br>
            </div>
        </form>
</body>

</html>