<?php
session_start();

// Solo usuarios autenticados pueden eliminar eventos
if (!isset($_SESSION['user_id'])) {
    header("Location: /KnockOut_Zone/controller/login.php");
    exit();
}

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'knockoutzone';

try {
    // Verifica que venga un ID por POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['event_id'])) {
        throw new Exception("Solicitud inválida");
    }

    $event_id = intval($_POST['event_id']);

    // Conexión a la base de datos
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);
    if ($conn->connect_error) {
        throw new Exception("Error de conexión: " . $conn->connect_error);
    }

    // Opcional: verificar si el evento pertenece al usuario logueado
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ? AND created_by = ?");
    if (!$stmt) {
        throw new Exception("Error al preparar consulta: " . $conn->error);
    }

    $stmt->bind_param("ii", $event_id, $_SESSION['user_id']);

    if (!$stmt->execute()) {
        throw new Exception("Error al eliminar evento: " . $stmt->error);
    }

    $_SESSION['success_message'] = "Evento eliminado correctamente.";
    header("Location: ../view/events.php");
    exit();

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
