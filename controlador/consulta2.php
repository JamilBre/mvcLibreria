<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener ejemplares que no fueron devueltos
$query = $miPDO->prepare('
    SELECT E.id, L.titulo, P.idUsuario, U.nombre AS nombreUsuario, P.fechaPrestamo
    FROM EJEMPLAR E
    JOIN LIBRO L ON E.idLibro = L.id
    JOIN PRESTAMO P ON E.id = P.idEjemplar
    JOIN USUARIO U ON P.idUsuario = U.id
    WHERE P.fechaDevolucion IS NULL
');
$query->execute();
$ejemplares = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplares No Devueltos - CRUD PHP</title>
</head>
<body>
    <h2>Ejemplares que no fueron devueltos aún</h2>
    <table border="1">
        <tr>
            <th>ID Ejemplar</th>
            <th>Título</th>
            <th>ID Usuario</th>
            <th>Nombre Usuario</th>
            <th>Fecha de Préstamo</th>
        </tr>
        <?php foreach ($ejemplares as $ejemplar): ?>
            <tr>
                <td><?= $ejemplar['id'] ?></td>
                <td><?= $ejemplar['titulo'] ?></td>
                <td><?= $ejemplar['idUsuario'] ?></td>
                <td><?= $ejemplar['nombreUsuario'] ?></td>
                <td><?= $ejemplar['fechaPrestamo'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
