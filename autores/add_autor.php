<?php
require '../includes/db.php'; // Conexión a la base de datos
//require '../includes/header.php'; // Cabecera común

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
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Biblioteca - Añadir Autor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 20px; /* Ajuste el espaciado entre el encabezado y la lista de libros */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/index.php">Biblioteca</a>
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
        <h2>Añadir Autor</h2>
        <?php if (isset($error)) : ?>
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

<?php require '../includes/footer.php'; // Pie de página común 
?>
