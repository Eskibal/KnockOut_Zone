<?php
    session_start();



    class UserController {

        private $conn;

        public function __construct() {
            
        }

        public function login(): void {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $stmt = $this->conn->prepare(query: "SELECT Username, Passwd FROM Users WHERE Username=? AND Passwd=?");
            $stmt->bind_param(types: "ss", var: $username, vars: $password);
            $stmt->execute();
        
            if ($stmt->fetch()) {
                $_SESSION['logged'] = true;
                $_SESSION['user'] = $username;

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