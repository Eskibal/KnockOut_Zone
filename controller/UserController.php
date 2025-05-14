<?php
// session_start();

class UserController
{

    private $conn;

    public function __construct()
    {
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
            $_SESSION["error"] = "Username or password incorrect";
            header("Location: ../view/vlogin.php");
            exit();
        }
    }


    public function logout(): void
    {
        session_destroy();
        header(header: "Location:../view/index.html");
        exit();
    }

    public function register(): void
    {
        $username = $_POST["user"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        $nombre_img = $_FILES["pfp"]["name"];
        $tipo = $_FILES["pfp"]["type"];
        $tamano = $_FILES["pfp"]["size"];

        if (empty($username) || empty($password) || empty($email)) {
            $_SESSION["error"] = "All fields are required";
            header("Location: ../view/vregister.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "Invalid email format";
            header("Location: ../view/vregister.php");
            exit();
        }

        // Comprobar si ya existe
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION["error"] = "User or email already exists";
            header("Location: ../view/vregister.php");
            exit();
        }

        // Por defecto no hay imagen
        $nombre_final = null;

        // Si hay imagen, guardarla
        if (!empty($nombre_img) && $tamano <= 2000000) {
            if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {
                $directorio = $_SERVER['DOCUMENT_ROOT'] . "/knockoutzone/resources/profiles/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombre_final = time() . "_" . basename($nombre_img);
                $ruta_guardada = $directorio . $nombre_final;

                move_uploaded_file($_FILES["pfp"]["tmp_name"], $ruta_guardada);
            }
        }

        // Insertar usuario
        $stmt = $this->conn->prepare("INSERT INTO users (name, password, email, path_pfp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $nombre_final);

        if ($stmt->execute()) {
            $_SESSION["success"] = "User registered successfully";
            header("Location: ../view/vlogin.php");
            exit();
        } else {
            $_SESSION["error"] = "Error registering user";
            header("Location: ../view/vregister.php");
            exit();
        }
    }


    public function subirImagenPerfil(): void
    {
        if (!isset($_SESSION["user"])) {
            header("Location: ../view/profile.php");
            exit();
        }

        $user = $_POST['name'];
        $nombre_img = $_FILES['imagen']['name'];
        $tipo = $_FILES['imagen']['type'];
        $tamano = $_FILES['imagen']['size'];

        if (!empty($nombre_img) && $tamano <= 2000000) {
            if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {

                $directorio = $_SERVER['DOCUMENT_ROOT'] . "/knockoutzone/resources/profiles/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nuevo_nombre = time() . "_" . basename($nombre_img);
                $ruta_guardada = $directorio . $nuevo_nombre;

                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_guardada)) {
                    $stmt = $this->conn->prepare("UPDATE users SET path_pfp = ? WHERE name = ?");
                    $stmt->bind_param("ss", $nuevo_nombre, $user);
                    $stmt->execute();

                    $_SESSION["success"] = "Image uploaded successfully.";
                } else {
                    $_SESSION["error"] = "Error while saving image.";
                }
            } else {
                $_SESSION["error"] = "Format not allowed. Only JPG or PNG.";
            }
        } else {
            $_SESSION["error"] = "Empty image or to big.";
        }

        header("Location: ../view/profile.php");
        exit();
    }
    public function registerAdmin(): void
    {
        $username = $_POST["user"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        $nombre_img = $_FILES["pfp"]["name"];
        $tipo = $_FILES["pfp"]["type"];
        $tamano = $_FILES["pfp"]["size"];

        if (empty($username) || empty($password) || empty($email)) {
            $_SESSION["error"] = "All fields are required";
            header("Location: ../view/vregister.php");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "Invalid email format";
            header("Location: ../view/vregister.php");
            exit();
        }

        $stmt = $this->conn->prepare("SELECT * FROM users WHERE name=? OR email=?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $_SESSION["error"] = "User or email already exists";
            header("Location: ../view/vregister.php");
            exit();
        }

        // Por defecto: sin imagen
        $nombre_final = null;

        if (!empty($nombre_img) && $tamano <= 2000000) {
            if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {
                $directorio = $_SERVER['DOCUMENT_ROOT'] . "/knockoutzone/resources/profiles/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                $nombre_final = time() . "_" . basename($nombre_img);
                $ruta_guardada = $directorio . $nombre_final;

                move_uploaded_file($_FILES["pfp"]["tmp_name"], $ruta_guardada);
            }
        }

        $stmt = $this->conn->prepare("INSERT INTO users (name, password, email, path_pfp) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $password, $email, $nombre_final);

        if ($stmt->execute()) {
            $_SESSION["success"] = "Admin registered successfully";
            header("Location: ../view/vlogin.php");
            exit();
        } else {
            $_SESSION["error"] = "Error registering admin";
            header("Location: ../view/vregister.php");
            exit();
        }
    }
}
