<?php
require 'includes/db.php';
$stmt = $pdo->query("SELECT libros.id, libros.titulo, autores.nombre as autor FROM libros JOIN autores ON libros.autor_id = autores.id");
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Biblioteca</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .container {
            padding-top: 20px; /* Ajuste el espaciado entre el encabezado y la lista de libros */
        }
    </style>
</head>
<body>
    <?php require 'includes/header.php'; ?>
    
    <div class="container">
        <h2>Lista de Libros</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($libros as $libro): ?>
                <tr>
                    <td><?php echo $libro['id']; ?></td>
                    <td><?php echo $libro['titulo']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>
                    <td>
                        <a href="libros/edit_libro.php?id=<?php echo $libro['id']; ?>" class="btn btn-primary">Editar</a>
                        <a href="libros/delete_libro.php?id=<?php echo $libro['id']; ?>" class="btn btn-danger">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <footer class="text-center mt-5">Aplicación creada por Sofía Sanmartín</footer>
    
    <?php require 'includes/footer.php'; ?>
</body>
</html>
