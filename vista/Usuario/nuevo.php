<?php
//Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recogemos las variables
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
    $direccion = isset($_REQUEST['direccion']) ? $_REQUEST['direccion'] : null;
    $telefono = isset($_REQUEST['telefono']) ? $_REQUEST['telefono'] : null;
    //Variables
    $hostDB = '127.0.0.1';
    $nombreDB = 'BdBiblioteca';
    $usuarioDB = 'root';
    $contrasenaDB = '';
    //Conecta con la base
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    //Prepara insert
    $miInsert = $miPDO->prepare('INSERT INTO USUARIO VALUES (:id, :nombre, :telefono, :direccion)');
    //Ejecuta INSERT con los datos
    $miInsert->execute(
        array(
            'id' => $id,
            'nombre' => $nombre,
            'direccion' => $direccion,
            'telefono' => $telefono
        )
    );
    //Redireccionamos a leer
    header('Location: listar.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear - CRUD PHP</title>
</head>
<body>
    <form action="" method="post">
    <p>
        <label for="id">Identificación</label>
        <input id="id" type="num" name="id">
    </p>
    <p>
        <label for="nombre">Nombre </label>
        <input id="nombre" type="text" name="nombre">
    </p>
    <p>
        <label for="direccion">Dirección</label>
        <input id="direccion" type="text" name="direccion">
    </p>
    <p>
        <label for="telefono">Teléfono</label>
        <input id="telefono" type="text" name="telefono">
    </p>
    <p>
        <input type="submit" value="Guardar">
    </p>
    </form>
</body>
</html>