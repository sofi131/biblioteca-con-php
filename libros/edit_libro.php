<?php
require '../includes/db.php'; // Conexión a la base de datos
//require '../includes/header.php'; // Cabecera común

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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Libro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 20px; /* Ajuste el espaciado entre el encabezado y el contenido */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/index.php">
            <img src="../img/library.png" alt="Biblioteca" width="50" height="50" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Libros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../autores/add_autor.php">Añadir Autor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../libros/add_libro.php">Añadir Libro</a>
                </li>
            </ul>
        </div>
    </nav>

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
</body>
</html>
