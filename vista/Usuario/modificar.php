<?php
//Variables
$hostDB = '127.0.0.1';
$nombreDB = 'BdBiblioteca';
$usuarioDB = 'root';
$contrasenaDB = '';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
$nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
$direccion = isset($_REQUEST['direccion']) ? $_REQUEST['direccion'] : null;
$telefono = isset($_REQUEST['telefono']) ? $_REQUEST['telefono'] : null;
//Conecta con la base
$hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
$miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
//Comprabamos si recibimos datos por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Prepara UPDATE
    $miUpdate = $miPDO->prepare('UPDATE USUARIO SET nombre = :nombre, direccion= :direccion, telefono = :telefono WHERE id = :id');
    //Ejecutar UPDATE con los datos
    $miUpdate->execute(
        [
            'id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'telefono' => $telefono
        ]
    );
    //Redireccionamos a Leer
    header('Location: listar.php');
} else{
    //Prepara Select
    $miConsulta = $miPDO->prepare('SELECT * FROM USUARIO WHERE id = :id;');
    //Ejecutar consulta
    $miConsulta->execute(
        [
            'id' => $id
        ]
    );
}
//Obtiene un resultado
$usuario = $miConsulta->fetch();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar - CRUD PHP</title>
</head>
<body>
    <form method="post">
        <p>
            <label for="nombre">Nombre </label>
            <input id="nombre" type="text" name="nombre" value="<?= $usuario['nombre'] ?>">
        </p>
        <p>
            <label for="direccion">Dirección</label>
            <input id="direccion" type="text" name="direccion" value="<?= $usuario['direccion'] ?>">
        </p>
        <p>
            <label for="telefono">Teléfono</label>
            <input id="telefono" type="text" name="telefono" value="<?= $usuario['telefono'] ?>">
        </p>
        <p>
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Modificar">
        </p>
    </form>
</body>
</html>