<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /KnockOut_Zone/controller/login.php");
    exit();
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'knockoutzone';

try {
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = htmlspecialchars(trim($_POST['title']));
        $datetime = $_POST['datetime'];
        $location = htmlspecialchars(trim($_POST['location']));
        $description = htmlspecialchars(trim($_POST['description'] ?? ''));
        $created_by = $_SESSION['user_id'];

        if (empty($title) || empty($datetime) || empty($location)) {
            throw new Exception("Todos los campos obligatorios deben completarse");
        }

        $formatted_datetime = date('Y-m-d H:i:s', strtotime($datetime));
        $image_path = null;

        if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../images/'; // Ruta sin subcarpetas

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $ext = strtolower(pathinfo($_FILES['event_image']['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($ext, $allowed)) {
                throw new Exception("Solo se permiten imágenes JPG, PNG o GIF");
            }

            $file_name = uniqid() . '.' . $ext;
            $target_path = $upload_dir . $file_name;

            if (move_uploaded_file($_FILES['event_image']['tmp_name'], $target_path)) {
                $image_path = 'images/' . $file_name; // Ruta relativa que apunta directamente a /images/
            }
        }

        $stmt = $conn->prepare("INSERT INTO events (title, event_date, location, description, image_path, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Error al preparar la consulta: " . $conn->error);
        }

        $stmt->bind_param("sssssi", $title, $formatted_datetime, $location, $description, $image_path, $created_by);

        if ($stmt->execute()) {
            header("Location: ../view/events.php");
            exit();
        } else {
            throw new Exception("Error al ejecutar: " . $stmt->error);
        }
    }
} catch (Exception $e) {
    $_SESSION['error_message'] = $e->getMessage();
    header("Location: ../view/events.php?error=1");
    exit();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
