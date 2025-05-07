<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in Admin - Knockout Zone</title>
    <link rel="stylesheet" href="viewcss/knockoutsignadmin.css">
</head>

<body>
    <div class="container">
        <a href="index.html" id="logo">
            <img id="logo" src="../images/logo.png" alt="Home">
        </a>
        <form action="../controller/signadmin.php" method="post">
            <input type="hidden" name="register" value="1">
            <label for="user">User</label>
            <input type="text" name="user" id="user" placeholder="crew_mccrew">

            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="crew@email.com">

            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="123ABC..">
            <label for="pfp">Profile picture</label>
            <p/>
            <input type="file" name="pfp" id="pfp" accept=".jpg, .jpeg, .png, .gif">
            <div class="link">
                Got an account?&nbsp;<a href="knockoutlogin.php">Log in!</a>
            </div>
            <div class="link">
                Want to be a&nbsp;<a href="knockoutsignin.php">Knockout User?</a> 
            </div>
            <input type="submit" value="Register as an Admin">
        </form>
    </div>
</body>

</html>