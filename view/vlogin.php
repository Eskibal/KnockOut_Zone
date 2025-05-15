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
    <title>Login - Knockout Zone</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="../resources/images/logolightbig.png" type="image/x-icon" sizes="16x16">
</head>

<body>
    <div class="form-container">
        <?php if ($error): ?>
            <p style="color: red; text-align: center; font-weight: bold; margin-top: 10px;">
                <?= htmlspecialchars($error) ?>
            </p>
        <?php endif; ?>
        <h1>LOG IN</h1>
        <form action="../controller/login.php" method="POST">
            <hr>
            <input type="hidden" name="login" value="1">
            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="user@gmail.com" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="123ABC.." required>
            <input type="submit" value="Log in" name="login">
            <hr>
            Don't have an account? <a href="vregister.php">Create one!</a>
        </form>
</body>

</html>