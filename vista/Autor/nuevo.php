<?php
//Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recogemos las variables
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $nombre = isset($_REQUEST['nombre']) ? $_REQUEST['nombre'] : null;
    //Variables
    $hostDB = '127.0.0.1';
    $nombreDB = 'BdBiblioteca';
    $usuarioDB = 'root';
    $contrasenaDB = '';
    //Conecta con la base
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    //Prepara insert
    $miInsert = $miPDO->prepare('INSERT INTO AUTOR VALUES (:id, :nombre)');
    //Ejecuta INSERT con los datos
    $miInsert->execute(
        array(
            'id' => $id,
            'nombre' => $nombre
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
        <label for="id">Codigo</label>
        <input id="id" type="num" name="id">
    </p>
    <p>
        <label for="nombre">Nombre del Autor</label>
        <input id="nombre" type="text" name="nombre">
    </p>
    <p>
        <input type="submit" value="Guardar">
    </p>
    </form>
</body>
</html>