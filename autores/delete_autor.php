<?php
require '../includes/db.php'; // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eliminar libros asociados al autor
    $stmt = $pdo->prepare("DELETE FROM libros WHERE autor_id = :autor_id");
    $stmt->execute(['autor_id' => $id]);

    // Eliminar el autor
    $stmt = $pdo->prepare("DELETE FROM autores WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
?>
