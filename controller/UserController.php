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


    public function subirImagenPerfil(): void
    {

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
