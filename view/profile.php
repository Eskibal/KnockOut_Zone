<?php
session_start();
$conn = new mysqli("localhost", "root", "", "knockoutzone");
$user = $_SESSION["user"];

$query = $conn->prepare("SELECT profile_img FROM users WHERE name = ?");
$query->bind_param("s", $user);
$query->execute();
$result = $query->get_result();
$row = $result->fetch_assoc();

if (!empty($row["profile_img"])) {
    echo "<img src='../images/profiles/" . $row["profile_img"] . "' alt='Perfil' style='width:150px; border-radius:50%;'>";
} else {
    echo "<p>Sin imagen de perfil</p>";
}
?>
