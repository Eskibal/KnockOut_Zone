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
        $dbname = "knockoutzone";

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

    public function register(): void {}


    public function subirImagenPerfil(): void {
        session_start();
    
        // Solo admin puede subir imagen (ajusta esto si usas roles)
        if ($_SESSION["user"] !== 'admin') {
            header("Location: ../view/profile.php");
            exit();
        }
    
        $nombre_img = $_FILES['imagen']['name'];
        $user = $_POST['name'];
        $tipo = $_FILES['imagen']['type'];
        $tamano = $_FILES['imagen']['size'];
    
        if (!empty($nombre_img) && ($tamano <= 2000000)) {
            if ($tipo == "image/jpeg" || $tipo == "image/jpg" || $tipo == "image/png") {
    
                $directorio = $_SERVER['DOCUMENT_ROOT'] . "/knockoutzone/images/Profiles/";
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
    
                $nuevo_nombre = time() . "_" . $nombre_img;
                $ruta_guardada = $directorio . $nuevo_nombre;
    
                move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_guardada);
    
                $stmt = $this->conn->prepare("UPDATE users SET profile_img = ? WHERE name = ?");
                $stmt->bind_param("ss", $nuevo_nombre, $user);
                $stmt->execute();
    
                $_SESSION["success"] = "Image updated successfully.";
                header("Location: ../view/profile.php");
                exit();
            } else {
                $_SESSION["error"] = "Only JPG or PNG images are allowed.";
                header("Location: ../view/profile.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "The image is too large or has not been sent.";
            header("Location: ../view/profile.php");
            exit();
        }
    }
    
    


}


