<?php
//variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';
//conecta con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Prepara select 
$miConsulta = $miPDO->prepare('Select * From USUARIO;');
//ejecuta consulta
$miConsulta->execute();

?>
<!DOCTYPE html>
<html lang="es">
<head>
        <meta charset="UTF-8">
        <title>Leer - CRUD PHP</title>
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
            }
            table td{
                border: 1px solid blueviolet;
                text-align: center;
                padding: 1.3rem;
            }
            .button{
                border-radius: .5rem;
                color: whithe;
                background-color: #ffc9d2;
                padding: 1rem;
                text-decoration: none;
            }
        </style>
</head>
<body>
    <p><a class="button" href="nuevo.php">Crear</a></p>
    <table>
        <tr>
            <th>Identificación </th>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($miConsulta as $clave => $valor): ?>
            <tr>
                <td><?= $valor['id']; ?></td>
                <td><?= $valor['nombre']; ?></td>
                <td><?= $valor['direccion']; ?></td>
                <td><?= $valor['telefono']; ?></td>
                <!-- Se utilizará más adelante para indicar si se requiere modificar o eliminar el registra -->
                <td><a class="button" href="modificar.php?id=<?= $valor['id'] ?>">Modificar</a></td>
                <td><a class="button" href="borrar.php?id=<?= $valor['id'] ?>">Borrar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p><a class="button" href="../../index.php"></a>Volver</p>
    <footer style="text-align: center; font-weight: bold; margin-top: auto; margin-bottom: 10px;">

    </footer>
</body>
</html>