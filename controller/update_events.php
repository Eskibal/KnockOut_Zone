<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    die("Acceso denegado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configuración de la base de datos
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'knockoutzone';

    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Escapar datos
    $event_id   = intval($_POST['event_id']);
    $title      = $conn->real_escape_string($_POST['title']);
    $datetime   = $conn->real_escape_string($_POST['datetime']);
    $location   = $conn->real_escape_string($_POST['location']);
    $description = $conn->real_escape_string($_POST['description']);
    $user_id    = intval($_SESSION['user_id']);

    // Verificar que el evento pertenece al usuario actual
    $check = $conn->query("SELECT * FROM events WHERE id = $event_id AND created_by = $user_id");
    if ($check->num_rows === 0) {
        $conn->close();
        die("No tienes permiso para actualizar este evento.");
    }

    // Procesar imagen si se sube una nueva
    $image_path_sql = '';
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['event_image']['tmp_name'];
        $image_name = basename($_FILES['event_image']['name']);
        $upload_dir = '../images/';
        $image_path = $upload_dir . $image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
            // Ruta relativa para base de datos
            $image_path_db = 'images/' . $image_name;
            $image_path_sql = ", image_path = '$image_path_db'";
        }
    }

    // Ejecutar UPDATE
    $sql = "UPDATE events SET 
                title = '$title',
                event_date = '$datetime',
                location = '$location',
                description = '$description'
                $image_path_sql
            WHERE id = $event_id AND created_by = $user_id";

    if ($conn->query($sql)) {
        header("Location: ../view/events.php");
        exit;
    } else {
        echo "Error al actualizar el evento: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Método no permitido.";
}
