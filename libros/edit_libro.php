<?php
require '../includes/db.php'; // Conexión a la base de datos
require '../includes/header.php'; // Cabecera común

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos del libro
    $stmt = $pdo->prepare("SELECT * FROM libros WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $libro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$libro) {
        die('Libro no encontrado.');
    }

    // Obtener la lista de autores
    $stmt = $pdo->query("SELECT * FROM autores");
    $autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    if (!empty($titulo) && !empty($autor_id)) {
        $stmt = $pdo->prepare("UPDATE libros SET titulo = :titulo, autor_id = :autor_id WHERE id = :id");
        $stmt->execute(['titulo' => $titulo, 'autor_id' => $autor_id, 'id' => $id]);
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>

<div class="container">
    <h2>Editar Libro</h2>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($libro['titulo']); ?>" required>
        </div>
        <div class="form-group">
            <label for="autor_id">Autor:</label>
            <select class="form-control" id="autor_id" name="autor_id" required>
                <?php foreach ($autores as $autor): ?>
                    <option value="<?php echo $autor['id']; ?>" <?php if ($libro['autor_id'] == $autor['id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($autor['nombre']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<?php require '../includes/footer.php'; // Pie de página común ?>

