<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Knockout Zone</title>
    <link rel="stylesheet" href="viewcss/knockoutlogin.css">
</head>

<body>
    <div class="container">
        <a href="knockouthome.html" id="logo">
            <img id="logo" src="../images/logo.png" alt="Home">
        </a>
        <form action="../controller/login.php" method="POST">
            <input type="hidden" name="login" value="1">
            <label for="username">User</label>
            <input type="text" name="username" id="username" placeholder="example_mcexample">

            <label for="password">Password</label>
            <input type="text" name="password" id="password" placeholder="123ABC..">
            <!--<div class="link">
                <a href="#">¿Has olvidado la contraseña?</a> 
            </div>-->
            <div class="link">
                No account? <a href="knockoutsignin.php">Register!</a> 
            </div>
            <input type="submit" value="Log in" name="login">
        </form>
    </div>
</body>

</html>