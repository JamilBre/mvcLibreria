<?php
//variables
$hostDB = '127.0.0.1';
$nombreDB = 'ejemplo';
$usuarioDB = 'root';
$contrasenaDB = '';
//conecta con la base de datos
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Prepara select 
$miConsulta = $miPDO->prepare('Select * From clientes;');
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
            <th>Tipo de Documento</th>
            <th>Nro de Documento</th>
            <th>Nombre completo / Razón social</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Fecha de Nacimiento / Fecha de Creación</th>
            <td></td>
            <td></td>
        </tr>
        <?php foreach ($miConsulta as $clave => $valor): ?>
            <tr>
                <td><?= $valor['tipoDoc']; ?></td>
                <td><?= $valor['nroDoc']; ?></td>
                <td><?= $valor['nombreCompleto']; ?></td>
                <td><?= $valor['direccion']; ?></td>
                <td><?= $valor['telefono']; ?></td>
                <td><?= $valor['email']; ?></td>
                <td><?= $valor['fecha']; ?></td>
                <!-- Se utilizará más adelante para indicar si se requiere modificar o eliminar el registra -->
                <td><a class="button" href="modificar.php?nroDoc=<?= $valor['nroDoc'] ?>">Modificar</a></td>
                <td><a class="button" href="borrar.php?nroDoc=<?= $valor['nroDoc'] ?>">Borrar</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <footer style="text-align: center; font-weight: bold; margin-top: auto; margin-bottom: 10px;">

    </footer>
</body>
</html>