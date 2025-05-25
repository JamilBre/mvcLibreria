<?php
// Variables de conexión
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conectar con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Obtener ranking de autores
$query = $miPDO->prepare('
    SELECT A.nombre, COUNT(L.id) AS cantidadLibros
    FROM AUTOR A
    JOIN LIBRO L ON A.id = L.idAutor
    GROUP BY A.id, A.nombre
    ORDER BY cantidadLibros DESC
');
$query->execute();
$rankingAutores = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Autores - CRUD PHP</title>
</head>
<body>
    <h2>Ranking de Autores con más Libros en la Biblioteca</h2>
    <table border="1">
        <tr>
            <th>Nombre del Autor</th>
            <th>Cantidad de Libros</th>
        </tr>
        <?php foreach ($rankingAutores as $autor): ?>
            <tr>
                <td><?= $autor['nombre'] ?></td>
                <td><?= $autor['cantidadLibros'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
