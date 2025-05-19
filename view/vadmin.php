<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Knockout Zone</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="icon" href="../resources/images/logolightbig.png" sizes="256x256">
</head>

<body>
    <div class="form-container">
        <h1>ADMIN REGISTER</h1>
        <?php
        session_start();
        if (isset($_SESSION["error"])) {
            echo '<p style="color:red; text-align:center; font-weight:bold;">' . $_SESSION["error"] . '</p>';
            unset($_SESSION["error"]);
        }
        if (isset($_SESSION["success"])) {
            echo '<p style="color:green; text-align:center; font-weight:bold;">' . $_SESSION["success"] . '</p>';
            unset($_SESSION["success"]);
        }
        ?>

        <form action="../controller/signadmin.php" method="POST" enctype="multipart/form-data">
            <hr>
            <input type="hidden" name="register" value="1">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" placeholder="admin@email.com" required>
            <div class="label-group">
                <label for="user">Username *</label>
                <label for="password">Password *</label>
            </div>
            <div class="form-group">
                <input type="text" name="user" id="user" placeholder="knockout_admin" required>&nbsp;
                <input type="password" name="password" id="password" placeholder="123ABC.." required>
            </div>
            <label for="pfp">Profile Picture (optional)</label>
            <input type="file" name="pfp" id="pfp" accept="image/*">
            <input type="submit" value="Register">
            <hr>
            <div class="form-options">
                Got an account? <a href="vlogin.php"> Log in!</a>
                <br>Become a <a href="vregister.php">Knockout User!</a></br>
            </div>
        </form>
    </div>
</body>

</html>