<?php
//Comprobar si se recibió datos POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Recogemos las variables
    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : null;
    $idLibro = isset($_REQUEST['idLibro']) ? $_REQUEST['idLibro'] : null;
    $localizacion = isset($_REQUEST['localizacion']) ? $_REQUEST['localizacion'] : null;
    //Variables
    $hostDB = '127.0.0.1';
    $nombreDB = 'BdBiblioteca';
    $usuarioDB = 'root';
    $contrasenaDB = '';
    //Conecta con la base
    $hostPDO = "mysql:host=$hostDB;dbname=$nombreDB;";
    $miPDO = new PDO($hostPDO, $usuarioDB, $contrasenaDB);
    //Prepara insert
    $miInsert = $miPDO->prepare('INSERT INTO EJEMPLAR VALUES (:id, :idLibro,:localizacion)');
    //Ejecuta INSERT con los datos
    $miInsert->execute(
        array(
            'id' => $id,
            'idLibro' => $idLibro,
            'localizacion' => $localizacion
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
            <label for="idLibro">Codigo del libro</label>
            <input id="idLibro" type="text" name="idLibro">
        </p>
        <p>
            <label for="localizacion">Localizacion</label>
            <input id="localizacion" type="text" name="localizacion">
        </p>
    <p>
        <input type="submit" value="Guardar">
    </p>
    </form>
</body>
</html>