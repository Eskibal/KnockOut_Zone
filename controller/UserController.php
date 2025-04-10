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
            
            // Check connection
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
            echo "Connection Succesfully";
        }
        public function login(): void {
            // get data from form request
            $username = $_POST["username"];
            $password = $_POST["password"];

            //check BBDD
            $stmt = $this->conn->prepare(query: "SELECT name, password FROM users WHERE name=? AND password=?");
            $stmt->bind_param( "ss", $username, $password);
            $stmt->execute();
        
            if ($stmt->fetch()) {
                // authentication success
                $_SESSION["logged"] = true;
                $_SESSION["user"] = $username;
                // close connection
                $this->conn->close();

                // redirect to home page
                header(header: "Location:../view/profile.php");
                exit();
            }
        }

        public function logout(): void {
            session_destroy();
            header(header: "Location:../view/knockoutlogin.php");
            exit();     

        }

        public function register(): void {

        }
    }
?>