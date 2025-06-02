<?php
// Variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conecta con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Consulta mejorada con JOIN para mostrar nombre del autor
$miConsulta = $miPDO->prepare('
    SELECT l.*, a.nombre as nombre_autor 
    FROM LIBRO l
    LEFT JOIN AUTOR a ON l.idAutor = a.id
    ORDER BY l.titulo;
');

// Ejecuta consulta
$miConsulta->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer - CRUD PHP</title>
    
    <!-- Enlace al archivo CSS -->
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>

    <!-- Botón "Crear" arriba de la tabla -->
    <div class="button-container">
        <a class="button" href="nuevo.php">Crear</a>
    </div>

    <!-- Tabla de libros -->
    <table>
        <tr>
            <th>Código</th>
            <th>Título</th>
            <th>ISBN</th>
            <th>Editorial</th>
            <th>Páginas</th>
            <th>Autor</th> <!-- Cambiado de "Id del Autor" a "Autor" -->
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($miConsulta as $libro): ?>
            <tr>
                <td><?= $libro['id']; ?></td>
                <td><?= $libro['titulo']; ?></td>
                <td><?= $libro['isbn']; ?></td>
                <td><?= $libro['editorial']; ?></td>
                <td><?= $libro['paginas']; ?></td>
                <td><?= $libro['nombre_autor'] ?? 'Desconocido'; ?></td> <!-- Mostrando nombre en lugar de ID -->
                <!-- Enlaces para modificar o borrar registros -->
                <td><a class="button" href="modificar.php?id=<?= $libro['id'] ?>">Modificar</a></td>
                <td><a class="button" href="borrar.php?id=<?= $libro['id'] ?>" onclick="return confirm('¿Está seguro?')">Borrar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Botón Volver debajo de la tabla -->
    <div class="button-container">
        <a class="button" href="../../index.php">Volver</a>
    </div>

    <footer style="text-align: center; font-weight: bold; margin-top: auto; margin-bottom: 10px;">
    </footer>

</body>
</html>