<?php
require '../includes/db.php'; // Conexión a la base de datos
require '../includes/header.php'; // Cabecera común

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    if (!empty($nombre)) {
        $stmt = $pdo->prepare("INSERT INTO autores (nombre) VALUES (:nombre)");
        $stmt->execute(['nombre' => $nombre]);
        header("Location: ../index.php");
        exit;
    } else {
        $error = "El nombre del autor no puede estar vacío.";
    }
}
?>

<div class="container">
    <h2>Añadir Autor</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>

<?php require '../includes/footer.php'; // Pie de página común ?>
