<?php
// Variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';

// Conecta con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);

// Prepara select 
$miConsulta = $miPDO->prepare('SELECT * FROM AUTOR;');

// Ejecuta consulta
$miConsulta->execute();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leer - CRUD PHP</title>
    
    <!-- Enlace al archivo CSS desde la carpeta 'css' en 'vista' -->
    <link rel="stylesheet" href="../css/form.css">
</head>
<body>
    <!-- Contenedor para el botón "Crear" alineado a la izquierda -->
    <div class="button-container">
        <a class="button" href="nuevo.php">Crear</a>
    </div>

    <!-- Tabla de autores -->
    <table>
        <tr>
            <th>Código</th>
            <th>Nombre del Autor</th>
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($miConsulta as $clave => $valor): ?>
            <tr>
                <td><?= $valor['id']; ?></td>
                <td><?= $valor['nombre']; ?></td>
                <!-- Enlace para modificar o borrar registros -->
                <td><a class="button" href="modificar.php?id=<?= $valor['id'] ?>">Modificar</a></td>
                <td><a class="button" href="borrar.php?id=<?= $valor['id'] ?>">Borrar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Botón Volver debajo de la tabla -->
    <div class="button-container">
        <a class="button" href="../../index.php">Volver</a>
    </div>

    <footer style="text-align: center; font-weight: bold; margin-top: auto; margin-bottom: 10px;"></footer>
</body>
</html>
