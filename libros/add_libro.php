<?php
require '../includes/db.php'; // Conexión a la base de datos
require '../includes/header.php'; // Cabecera común

// Obtener la lista de autores
$stmt = $pdo->query("SELECT * FROM autores");
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor_id = $_POST['autor_id'];
    if (!empty($titulo) && !empty($autor_id)) {
        $stmt = $pdo->prepare("INSERT INTO libros (titulo, autor_id) VALUES (:titulo, :autor_id)");
        $stmt->execute(['titulo' => $titulo, 'autor_id' => $autor_id]);
        header("Location: ../index.php");
        exit;
    } else {
        $error = "Todos los campos son obligatorios.";
    }
}
?>
<style>
    .container {
        padding-top: 20px;
        /* Ajuste el espaciado entre el encabezado y la lista de libros */
    }
</style>
<div class="container">
    <h2>Añadir Libro</h2>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" class="form-control" id="titulo" name="titulo" required>
        </div>
        <div class="form-group">
            <label for="autor_id">Autor:</label>
            <select class="form-control" id="autor_id" name="autor_id" required>
                <?php foreach ($autores as $autor) : ?>
                    <option value="<?php echo $autor['id']; ?>"><?php echo htmlspecialchars($autor['nombre']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Añadir</button>
    </form>
</div>

<?php require '../includes/footer.php'; // Pie de página común 
?>