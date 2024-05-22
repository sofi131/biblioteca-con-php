<?php
require '../includes/db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar el libro
    $stmt = $pdo->prepare("DELETE FROM libros WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
?>
