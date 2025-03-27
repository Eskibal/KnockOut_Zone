<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in - Knockout Zone</title>
    <link rel="stylesheet" href="viewcss/knockoutsignin.css">
</head>

<body>
    <div class="container">
        <a href="knockouthome.html" id="logo">
            <img id="logo" src="../images/logo.png" alt="Home">
        </a>
        <form action="signin.php" method="post">
            <input type="hidden" name="register" value="1">
            <label for="user">User</label>
            <input type="text" name="user" id="user" placeholder="example_mcexample">

            <label for="email">Email</label>
            <input type="text" name="email" id="email" placeholder="example@email.com">

            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="123ABC..">
            <div class="link">
                Got an account?&nbsp;<a href="knockoutlogin.php"> Log in!</a> 
            </div>
            <div class="link">
                Want to be a&nbsp;<a href="knockoutsignadmin.php">Knockout Admin?</a> 
            </div>
            <input type="submit" value="Register as a User">
        </form>
    </div>
</body>

</html>