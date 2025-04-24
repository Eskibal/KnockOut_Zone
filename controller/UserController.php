<?php
session_start();

class UserController
{

    private $conn;

    public function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "Knockoutzone";

        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connection Succesfully";
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

    public function register(): void {
        $username = $_POST["user"];
        $password = $_POST["password"];
        $email = $_POST["email"];
        // Validate input

        if (empty($username) || empty($password) || empty($email)) {
            $_SESSION["error"] = "All fields are required";
            header("Location: ../view/knockoutsignin.php");
            exit();
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "Invalid email format";
            header("Location: ../view/knockoutsignin.php");
            exit();
        }
        
        // Check if user already exists
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name=? OR email=?");
        $stmt->bind_param("ss", $username, $email); 
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION["error"] = "User or email already exists";
            header("Location: ../view/knockoutsignin.php");
            exit();
        }

        // Insert new user into the database    
        $stmt = $this->conn->prepare("INSERT INTO users (name, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);
        if ($stmt->execute()) {
            $_SESSION["success"] = "User registered successfully";
            header("Location: ../view/knockoutlogin.php");
            exit();
        } else {
            $_SESSION["error"] = "Error registering user";
            header("Location: ../view/knockoutsignin.php");
            exit();
        }
    }
}
