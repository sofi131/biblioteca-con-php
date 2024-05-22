<?php
require '../includes/db.php'; // Conexión a la base de datos
require '../includes/header.php'; // Cabecera común

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del autor
    $stmt = $pdo->prepare("SELECT * FROM autores WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $autor = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$autor) {
        die('Autor no encontrado.');
    }
} else {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    if (!empty($nombre)) {
        $stmt = $pdo->prepare("UPDATE autores SET nombre = :nombre WHERE id = :id");
        $stmt->execute(['nombre' => $nombre, 'id' => $id]);
        header("Location: ../index.php");
        exit;
    } else {
        $error = "El nombre del autor no puede estar vacío.";
    }
}
?>

<div class="container">
    <h2>Editar Autor</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($autor['nombre']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<?php require '../includes/footer.php'; // Pie de página común ?>