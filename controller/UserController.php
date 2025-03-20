<?php
    session_start();



    class UserController {

        private $conn;

        public function __construct() {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "knockoutzone";

            $this->conn = new mysqli($servername, $username, $password, $dbname);
            
            // Check connecti
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            echo "Connection Succesfully";
        }
        public function login(): void {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $stmt = $this->conn->prepare(query: "SELECT name, password FROM users WHERE name=? AND password=?");
            $stmt->bind_param( "ss", $username, $password);
            $stmt->execute();
        
            if ($stmt->fetch()) {
                $_SESSION["logged"] = true;
                $_SESSION["user"] = $username;

                $this->conn->close();

                header(header: "Location: ../view/profile.php");
                exit();
            }
        }

        public function logout(): void {

        }

        public function register(): void {

        }
    }
?>