<?php
// session_start();

class UserController
{

    private $conn;

    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "knockoutzone";

        $this->conn = new mysqli($servername, $username, $password, $dbname);
    
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    
        // echo "Connection Succesfully";  // comentar esto para evitar errores con header()
    }
    
    public function login(): void
    {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name=? AND password=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $_SESSION["logged"] = true;
            $_SESSION["user"] = $username;
            $this->conn->close();
            header("Location: ../view/profile.php");
            exit();
        } else {
            $_SESSION["error"] = "Usuario o contraseña incorrectos";
            header("Location: ../view/knockoutlogin.php");
            exit();
        }
    }


    public function logout(): void
    {
        session_destroy();
        header(header: "Location:../view/knockoutlogin.php");
        exit();
    }

    public function register(): void {}
}
